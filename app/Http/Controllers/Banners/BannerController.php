<?php

namespace App\Http\Controllers\Banners;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BannerRepository;
use App\Http\Requests\Banners\CreateBannerRequest;
use App\Http\Requests\Banners\UpdateBannerRequest;

class BannerController extends Controller
{
    /**
     * @var BannerRepositoryInterface
     */
    private $banner;

    /**
     * BannerController constructor.
     */

    public function __construct(BannerRepository $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of($this->banner->all())
            ->addColumn('action', function ($row) {                   
                    $btn = '<div style="display: flex">';
                    $btn =  $btn.'<a href="'.route('banners.edit', [$row->id]).'"
                                class="btn btn-primary m-2">
                                <i class="fa fa-pen"></i>
                            </a>';

                    $btn =  $btn.'<a class="btn btn-danger delete_button m-2" href="'.route('banners.destroy', $row->id).'">
                                <i class="fas fa-trash"></i>
                            </a>';

                    $btn = $btn.'</div>';
                return $btn;
            })
                ->editColumn('thumb', function ($row) {
                    return '<div style="display: flex;"><img src="' . $row->thumb . '" width="500px" height="auto" alt="Product image" class="product-thumbnail-small"></div>';
                })
                ->editColumn('title', function ($row) {

                    return  $row->title;
                })
                ->editColumn('caption', function ($row) {

                    return  $row->caption;
                })
                ->editColumn('url', function ($row) {

                    return  $row->url;
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1)
                        return 'Active';
                    else
                        return 'UnActive';
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'thumb'])
                ->make(true);
        }
        return view('banner.index');
    }


    public function create(Request $req)
    {

        return view('admin.banner.create');
    }

    public function edit($id)
    {

        $banner = Banner::where('id', $id)->first();
        return view('admin.banner.edit')->with(compact('banner'));
    }

    public function show($id)
    {

        $banner = Banner::where('id', $id)->first();
        return view('admin.banner.view')->with(compact('banner'));
    }




    public function store(CreateBannerRequest $request)
    {

        return $this->banner->store();
    }

    public function update(UpdateBannerRequest $request, $id)
    {

        return $this->banner->update($id);
    }


    public function destroy($id)
    {
        if (request()->ajax()) {
            return $this->banner->delete($id);
        }
    }
}
