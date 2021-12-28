<?php
class Model_Bookmaster extends Orm\Model {
    protected static $_table_name = 'bookmasters';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'book_title',
        'author_name',
        'publisher',
        'publication_day',
        'insert_day',
        'update_day',
    );


    public static function getBookId(){
        $getBookId = DB::select('id')->from('bookmasters')->execute()->as_array();
        return $getBookId;
    }

    public static function getDetailbook($id){
        $getDetailbook = DB::select()->from('bookmasters')->where('id', '=', $id)->execute()->as_array();
        return $getDetailbook;
    }
}


?>