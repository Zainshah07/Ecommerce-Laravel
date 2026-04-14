<?php
namespace App\Repositories\Eloquent;

use App\Models\TempImage;
use App\Helpers\UploadFileManager;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;
use App\Repositories\Contracts\TempImageRepositoryInterface;


class TempImageRepository implements TempImageRepositoryInterface{
    protected $model;

    public function __construct(TempImage $tempImage){
        $this->model = $tempImage;
    }

    public function index(){
        return $this->model->get();
    }

    public function store(array $data){
        
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
}
