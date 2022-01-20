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
        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data,false);
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

                    Session::set_flash('id', $id);
                    Session::set_flash('mess', $mess);
                    Session::set_flash('book_title', $book_title);
                    Session::set_flash('author_name', $author_name);
                    Session::set_flash('publisher', $publisher);
                    Session::set_flash('publication_day', $publication_day);
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0011'];
                    
                    Session::set_flash('id', $id);
                    Session::set_flash('messError', $mess);
                }
                // - - --  - -  - - - -  - - - - - -  - - --  
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            Session::set_flash('messError', $mess);
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
                    Session::set_flash('id', $id);
                    Session::set_flash('messError', $mess);
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - lấy chi tiết sách
                    $bookIdSearch = Model_Bookmaster::find($id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG003'];
                    // - trả về mảng: thông báo, lấy 1 mảng theo id và id 
                    Session::set_flash('id', $bookIdSearch['id']);
                    Session::set_flash('mess', $mess);
                    Session::set_flash('book_title', $bookIdSearch['book_title']);
                    Session::set_flash('author_name', $bookIdSearch['author_name']);
                    Session::set_flash('publisher', $bookIdSearch['publisher']);
                    Session::set_flash('publication_day', $bookIdSearch['publication_day']);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            Session::set_flash('messError', $mess);
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
                    Session::set_flash('id', $id);
                    Session::set_flash('messError', $mess);
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
                    Session::set_flash('id', $id);
                    Session::set_flash('mess', $mess);
                    Session::set_flash('book_title', $book_title);
                    Session::set_flash('author_name', $author_name);
                    Session::set_flash('publisher', $publisher);
                    Session::set_flash('publication_day', $publication_day);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            Session::set_flash('messError', $mess);
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
                    Session::set_flash('id', $id);
                    Session::set_flash('messError', $mess);
                }else{
                    // - lấy id cần xóa
                    $id = input::post('bookId');
                    // - hàm xóa từ model
                    Model_Bookmaster::db_delete($id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0015'];
                    // - trả về mảng: thông báo , mảng rỗng và id
                    Session::set_flash('id', $id);
                    Session::set_flash('mess', $mess);
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - trả về mảng: thông báo
            Session::set_flash('messError', $mess);
        }
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    public function action_thank(){
        $data = array();
        $this->template->title = 'Thanks';
        $this->template->content = View::forge('bookmaster/thank', $data);
    }   

   
}
