<?php

namespace App;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use App\MenuView;
use Illuminate\Database\Eloquent\SoftDeletes;
class Menus extends Model
{
    use SoftDeletes;
    protected $table = "menu";

    protected $fillable = [
        "id_menu_father",
        "id_permission",
        "text",
        "icon",
        "order",
        "level",
        "is_title",
        "url"
    ];

    public static function getMenus(){
        $menus = Menus::where('level',1)->with(['submenus','can:id,name'])->orderBy('order')->get()->toArray();
        //dd($menus);
        $finalMenu = [];
        foreach( $menus as $menu){
            if($menu["is_title"] ==  "SI"){
                $menuAux = $menu["text"];
            }else{
                $menuAux = Menus::crearFormato($menu);
            }
            array_push($finalMenu,$menuAux);
        }
        return $finalMenu;
    }


    public static function getMenusKeyFather($idFather) {

        $menus = Menus::where('id',$idFather)->with(['fatherMenuKeys:id,id_menu_father'])
                ->get(['id','id_menu_father'])->toArray();

        return Collect(\Arr::flatten($menus))->unique()->filter()->values();
    }

    public static function getMenusKeyFatherWithText($idFather) {

        $menusID = Menus::where('id',$idFather)->with(['fatherMenuKeys:id,id_menu_father'])
                ->get(['id','id_menu_father'])->toArray();


        return Collect(\Arr::flatten($menusID))->unique()->filter()->values();
    }

    private static function crearFormatoKeys( $fatherMenu ){

        if( COUNT($fatherMenu['father_menu_keys']) > 0 ) {

            return [ Menus::crearFormatoKeys($fatherMenu) ];
            // array_push($submenus,$submenuAux);

        }else{
            //dump($fatherMenu['id']);
            // dd($fatherMenu);
            return $fatherMenu['id'];
        }

    }



    private static function crearFormato( $menu ){
        if( COUNT($menu['submenus']) > 0 ) {

            $submenus = [];
            foreach( $menu["submenus"] as $submenu){
                $submenuAux = Menus::crearFormato($submenu);
                array_push($submenus,$submenuAux);
            }

            // if( !isset($menu["can"]) ){
                //dd($menu);
            // }

            return [
                "text" => $menu["text"] ,
                "icon" => $menu["icon"],
                "can"  => isset($menu["can"]) ? $menu["can"]["name"] : 'NO EXISTE',
                "submenu" => $submenus
            ];

        }else{
            // if( !isset($menu["can"]) ){
            //     dd($menu);
            // }
            return [
                "text" => $menu["text"] ,
                "icon" => $menu["icon"],
                "can"  => isset($menu["can"]) ? $menu["can"]["name"] : 'NO EXISTE',
                "url"  => $menu["url"]
            ];
        }
    }

    public function getIsTitleAttribute($value){
        return ($value) ? 'SI': 'NO';
    }

    public function can(){
        return $this->belongsTo(Permission::class,'id_permission','id');
    }

    public function menuView(){
        return $this->hasOne(MenuView::class,'id_menu','id');
    }

    public function relSubmenus(){
        return $this->hasMany(Menus::class,'id_menu_father','id')->orderBy('order');
    }

    public function submenus(){
        return $this->relSubmenus()->with(['submenus','can:id,name']);
    }

    public function submenu(){
        return $this->hasMany(Menus::class,'id_menu_father','id');
    }


    public function relBelongSubmenu(){
        return $this->belongsTo(Menus::class,'id_menu_father','id');
    }

    public function fatherMenu(){
        return $this->relBelongSubmenu()->with(['fatherMenu']);
    }

    public function fatherMenuKeys(){
        return $this->relBelongSubmenu()->with(['fatherMenuKeys:id,id_menu_father']);
    }

    public function fatherMenuKeysWithText(){
        return $this->relBelongSubmenu()->with(['fatherMenuKeys:id,id_menu_father,text']);
    }
}
