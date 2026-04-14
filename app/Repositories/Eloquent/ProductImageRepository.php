<?php
namespace App\Repositories\Eloquent;


use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Repositories\Contracts\ProductImageRepositoryInterface;

class ProductImageRepository implements ProductImageRepositoryInterface{
    protected $mode;

    public function __construct(ProductImage $product_image){
        $this->model = $product_image;
    }

    public function storeImage($product_id, $image){
              $originalName = $image->getClientOriginalName();
             $ext = pathinfo($originalName, PATHINFO_EXTENSION);

              $imageName = $product_id . '_' . time() . '.' . $ext;

        // Path for saving thumbnails
        $largePath = public_path('storage/uploads/products/large/' . $imageName);
        $smallPath = public_path('storage/uploads/products/small/' . $imageName);



        $manager = new ImageManager(new Driver());
        $img = $manager->read($image->getPathname());

        // Save Large (1200px)
        $imgLarge = clone $img;
        $imgLarge->scaleDown(1200);
        $imgLarge->save($largePath);

        // Save Small (400x450)
        $imgSmall = clone $img;
        $imgSmall->coverDown(400, 450);
        $imgSmall->save($smallPath);

        // Save DB record
        return $this->model->create([
            'product_id' => $product_id,
            'image'      => $imageName,
        ]);
    }

    public function deleteImage($product_id){
        $product_image=$this->model->find($product_id);
        File::delete(public_path('storage/uploads/products/large/'.$product_image->image));
        File::delete(public_path('storage/uploads/products/small/'.$product_image->image));

        $product_image->delete();
        return $product_image;

    }
}
