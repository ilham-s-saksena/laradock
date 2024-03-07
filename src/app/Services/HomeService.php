<?php

namespace App\Services;

use App\Models\Home;

class HomeService
{
    public function getAllContent()
    {
        return Home::all();
    }

    public function getById($i){
        $data = Home::find($i);
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function storeContent($data){
        $title = $data['title'];
        $description = $data['description'];
        $photo = $data['photo'];

        $new = new Home;
        $new->title = $title;
        $new->description = $description;
        $new->photo = $photo;
        $save = $new->save();
        
        if($save) {
            return true;
        } else {
            return false;
        }
    }

    public function updateContent($i, $data){
        $title = $data['title'];
        $description = $data['description'];

        $update = Home::find($i);

        if (!$update) {
            return 404;
        } else {

            
            if (isset($data['photo'])) {
                $update->photo = $data['photo'];    
            }
            $update->title = $title;
            $update->description = $description;
            $sv = $update->save();

            if ($sv) {
                return 201;
            } else {
                return 500;
            }
        }
    }

    public function deleteContent($i){
        $del = Home::find($i);
        if (!$del) {
            return false;
        } else {
            $del->delete();
            return true;
        }
    }
}
