<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\TempImage;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface{
    protected $model;

    public function __construct(Product $product){
        $this->model= $product;
    }

    public function all(){
        return $this->model->orderBy('created_at','DESC')->with(['product_images','product_sizes'])->get();
    }

    public function store(array $data){



        $product=  $this->model->create([
        'title' => $data['title'],
        'price' => $data['price'],
        'compare_price'=> $data['compare_price']?? null,
        'description'=> $data['description'] ?? null,
        'short_description'=> $data['short_description'] ?? null,
        'image'=> null,
        'category_id'=> $data['category_id'] ,
        'brand_id'=> $data['brand_id'] ?? null,
        'is_featured'=> $data['is_featured'] ?? null,
        'quantity'=> $data['quantity']?? null,
        'sku'=> $data['sku'],
        'barcode'=> $data['barcode'] ?? null,
        'status'=> $data['status'] ?? 1,
        ]);

        if(!empty($data['gallery'])){
            foreach($data['gallery'] as $key => $tempImageId){
                $tempImage = TempImage :: find($tempImageId);

                if($tempImage && $tempImage->name){
                    $extArray = explode('.',$tempImage->name);
                    $ext = end($extArray);
                    $imageName = $product->id .'_'. time().'.'.$ext;


                    $manager = new ImageManager(new Driver());
                    $tempPath = public_path( $tempImage->name);
                    $largePath = public_path('storage/uploads/products/large/' . $imageName);
                    $smallPath = public_path('storage/uploads/products/small/' . $imageName);

                    $imgLarge = $manager->read($tempPath);

                    // Large thumbnail (1200px)

                    $imgLarge->scaleDown(1200);
                    $imgLarge->save($largePath);

                    // Small thumbnail (400px)
                    $imgSmall = $manager->read($tempPath);
                    $imgSmall->coverDown(400,460);
                    $imgSmall->save($smallPath);

                    $productImage = new ProductImage();
                    $productImage->image = $imageName;
                    $productImage->product_id = $product->id;
                    $productImage->save();

                     if($key==0){
                    $product->image = $imageName;
                    $product->save();


                }

                }



            }
            return $product;
        }
    }

    public function find($id){
        $product= $this->model->with(['product_images','product_sizes'])->findOrFail($id);
        $productSizes=$product->product_sizes()->pluck('size_id')->toArray();
        $product->productSizes = $productSizes;
        return $product;

    }

    public function update($id, array $data){
        $product = $this->model->findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function updateDefaultImage($id, $data){
        $product = $this->model->find($id);
        $product->image = $data;
        $product->save();
        return $product;
    }

    public function delete($id){
        $product = $this->model->with('product_images')->findOrFail($id);
        if($product->product_images){
            foreach($product->product_images as $product_image){
                File::delete(public_path('storage/uploads/products/large/'.$product_image->image));
                File::delete(public_path('storage/uploads/products/small/'.$product_image->image));

            }
        }
        $product->delete();
        return $product;
    }

    public function saveProductImage(){

         if(isset($data['name'])&& $data['name']->isValid()){
            $upload = UploadFileManager::uploadFile($data['name'],'uploads/tempImages/');
            $data['name']=$upload['path'];

            $manager = new ImageManager(new Driver());
              $originalPath = public_path($upload['path']);

            $image = $manager->read($originalPath);
            $image->coverDown(400, 450);

            $thumbDir= public_path('storage/uploads/tempImages/thumbs/');
            $thumbPath= $thumbDir . basename($upload['path']);
            $image->save($thumbPath);
        }

        return $this->model->create($data);
    }
    // frontend

    public function getProducts($filters){
        $products= $this->model->orderBy('created_at','DESC')->where('status',1);

         if (!empty($filters['category'])) {
             $catArray= explode(',',$filters['category']);
            $products= $products->whereIn('category_id', $catArray);
    }


         if (!empty($filters['brand'])) {
             $brandArray= explode(',',$filters['brand']);
       $products= $products->whereIn('brand_id', $brandArray);
    }
         $products= $products->get();
        return $products;
    }

    public function latestProducts(){
        $products = $this->model->orderBy('created_at', 'DESC')->where('status',1)->limit(8)->get();
        return $products;
    }
    public function featuredProducts(){
        $products = $this->model->orderBy('created_at', 'DESC')->where('is_featured','yes')->where('status',1)->limit(8)->get();
        return $products;
    }
    public function getProduct($id){
        $product = $this->model->with(['product_images','product_sizes.size'])->findOrFail($id);
        return $product;
    }
}

