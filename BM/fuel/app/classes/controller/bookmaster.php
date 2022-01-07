<?php
class Controller_Bookmaster extends Controller_Template
{
    public static $messAge = array(
        'MSG001'=> "Vui lòng nhập id của sách",
        'MSG002'=> "Hãy nhập Book ID bằng chữ số 1 byte",
        'MSG003'=>" đã được tìm thấy",
        'MSG004'=> "không thể tìm thấy",
        'MSG005'=> "Đã phát sinh ngoại lệ bằng xử lý server",
        'MSG006'=> "Hãy nhập Book title",
        'MSG007'=> "Hãy nhập tên tác giả",
        'MSG008'=> "Hãy nhập nhà xuất bản",
        'MSG009'=> "Hãy nhập ngày xuất bản",
        'MSG0010'=> "Hãy nhập ngày xuất bản bằng chữ số 1 byte",
        'MSG0011'=> " đã được đăng ký. Hãy nhập ID khác",
        'MSG0012'=> " đã đăng ký sách",
        'MSG0013'=> " đã update sách",
        'MSG0014'=> " không được tìm thấy",
        'MSG0015'=> " đã xóa Book",
        'MSG0016'=> "Ngày xuất bản không hợp lệ",
    );
	public function action_index()
	{  
        $data = array();
        // - thêm: truyền dữ liệu qua view
        $add = Controller_Bookmaster::addBook();
        if(is_array($add)){
            if(count($add) == 3){
                $data = array('mess' => $add[0],'bookIdSearch' => $add[1],'id' => $add[2]);
            }elseif(count($add) == 2){
                $data = array('messError'=> $add[0],'id' => $add[1]);
            }elseif(count($add) == 1){
                $data = array('messError'=> $add[0]);
            } 
        }
        // - search: truyền dữ liệu qua view
        $searchId = Controller_Bookmaster::searchId();
        if(is_array($searchId)){
            if(count($searchId) == 3){
                $data = array('mess' => $searchId[0],'bookIdSearch' => $searchId[1],'id' => $searchId[2]);
            }elseif(count($searchId) == 2){
                $data = array('messError'=> $searchId[0],'id' => $searchId[1]);
            }elseif(count($searchId) == 1){
                $data = array('messError'=> $searchId[0]);
            }
        }
        // - update: truyền dữ liệu qua view
        $updateBook = Controller_Bookmaster::updateBook();
        if(is_array($updateBook)){
            if(count($updateBook) == 3){
                $data = array('mess' => $updateBook[0],'bookIdSearch' => $updateBook[1],'id' => $updateBook[2]);
            }elseif(count($updateBook) == 2){
                $data = array('messError'=> $updateBook[0],'id' => $updateBook[1]);
            }elseif(count($updateBook) == 1){
                $data = array('messError'=> $updateBook[0]);
            }
        }
        // - xóa: truyền dữ liệu qua view
        $deleteBook = Controller_Bookmaster::deleteBook();
        if(is_array($deleteBook)){
            if(count($deleteBook) == 3){
                $data = array('mess' => $deleteBook[0],'id' =>$deleteBook[2]);
            }elseif(count($deleteBook) == 2){
                $data = array('messError'=> $deleteBook[0],'id' =>$deleteBook[1]);
            }elseif(count($deleteBook) == 1){
                $data = array('messError'=> $deleteBook[0]);
            }
        }
        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data);
	}
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - controller chỉ có nhiệm vụ lấy thông tin người dùng 
    // - các chức năng thêm, sửa, xóa, tìm kiếm đều được xử lí từ model
    // - các function được gọi từ form và dùng js để thay đổi action   
    // - các hàm được tách riêng biệt
    // - fucntion: thêm
    public static function addBook(){
        try
        {
            if(input::post('btn-add')){        
                if(Model_Bookmaster::find(input::post('bookId')) === null){  
                    // - lấy thông tin người dùng nhập vào
                    $id = input::post('bookId');
                    $book_title = input::post('bookTitle');
                    $author_name = input::post('authorName');
                    $publisher = input::post('publisher');
                    $insert_day = date('y-m-d H:m:s');
                    $year = input::post('year');
                    $month = input::post('month');
                    $day = input::post('day');
                    $d = mktime(0,0,0,$month,$day,$year);
                    $publication_day = date('y-m-d',$d);
                    $dataBook = array(
                        'id' => $id,
                        'book_title' => $book_title,
                        'author_name' => $author_name,
                        'publisher' => $publisher,
                        'publication_day' => $publication_day,
                        'insert_day' => $insert_day,
                    );
                    // - hàm thêm từ model
                    Model_Bookmaster::db_insert($dataBook);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0012'];
                    // - trả về mảng: thông báo , thông tin người dùng và id
                    return array($mess,$dataBook,$id);
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0011'];
                    // - trả về mảng: thông báo và id
                    return array($mess,$id);
                }
                // - - --  - -  - - - -  - - - - - -  - - --  
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            return array($mess);
        }
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: tìm kiếm
    public static function searchId(){
        try{
            if(input::post('btn-search')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG004'];
                    // - trả về mảng
                    return array($mess,$id);
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - lấy chi tiết sách
                    $bookIdSearch = Model_Bookmaster::find($id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG003'];
                    // - trả về mảng: thông báo, lấy 1 mảng theo id và id 
                    return array($mess,$bookIdSearch,$id);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            return array($mess);
        }
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: udpate
    public static function updateBook(){
        try{
            if(input::post('btn-update')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){   
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');     
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0014'];
                    // - trả về mảng: thông báo và id
                    return array($mess,$id);
                }else {
                    // - lấy cập nhật từ người dùng nhập vào
                    $id = input::post('bookId');
                    $book_title = input::post('bookTitle');
                    $author_name = input::post('authorName');
                    $publisher = input::post('publisher');
                    $year = input::post('year');
                    $month = input::post('month');
                    $day = input::post('day');
                    $d = mktime(0,0,0,$month,$day,$year);
                    $publication_day = date('y-m-d',$d);
                    $update_day = date('y-m-d H:m:s');  
                    $dataBook = array(
                        'book_title' => $book_title,
                        'author_name' => $author_name,
                        'publisher' => $publisher,
                        'publication_day' => $publication_day,
                        'update_day' => $update_day,
                    );
                    // - hàm cập nhật từ model
                    Model_Bookmaster::db_update($dataBook,$id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0013'];
                    // - trả về mảng: thông báo, thông tin người dùng và id
                    return array($mess,$dataBook,$id);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            return array($mess);
        }
        
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: xóa
    public static function deleteBook(){
        try{
            if(input::post('btn-delete')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo 
                    $mess = Controller_Bookmaster::$messAge['MSG0014'];
                    // - trả về mảng
                    return array($mess,$id);
                }else{
                    // - lấy id cần xóa
                    $id = input::post('bookId');
                    // - hàm xóa từ model
                    Model_Bookmaster::db_delete($id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0015'];
                    // - trả về mảng: thông báo , mảng rỗng và id
                    return array($mess,'',$id);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            return array($mess);
        }
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    public function action_thank(){
        $data = array();
        $this->template->title = 'Thanks';
        $this->template->content = View::forge('bookmaster/thank', $data);
    }   

   
}
