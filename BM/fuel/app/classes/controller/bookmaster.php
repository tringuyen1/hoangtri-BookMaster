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
        // - trả về view
        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data,false);
	}
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - controller chỉ có nhiệm vụ lấy thông tin người dùng 
    // - các chức năng thêm, sửa, xóa, tìm kiếm đều được xử lí từ model
    // - các function được gọi từ form và dùng js để thay đổi action   
    // - các hàm được tách riêng biệt
    // - fucntion: thêm
    public function action_add(){
        $data = array();
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
                    // - lưu vào mảng data
                    $data = array(
                        'id' => $id,
                        'mess' => $mess,
                        'bookDetail' => $dataBook
                    );
                    // $this->template->content = View::forge('bookmaster/index',$data);
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0011'];
                    // - lưu vào mảng data
                    $data = array(
                        'id' => $id,
                        'messError' => $mess,
                    );
                }
                // - - --  - -  - - - -  - - - - - -  - - --  
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - lưu vào mảng data
            $data = array(
                'messError' => $mess,
            );
        }
        // - trả về view và data
        $this->template->title = 'book master';
        $this->template->content = View::forge('bookmaster/index',$data);
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: tìm kiếm
    public function action_search(){
        $data = array();
        try{
            if(input::post('btn-search')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG004'];
                    // - lưa vào mảng data
                    $data = array(
                        'id' => $id,
                        'messError' => $mess,
                    );
                }else{
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - lấy chi tiết sách
                    $bookIdSearch = Model_Bookmaster::find($id);
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG003'];
                    // - lưu vào mảng data
                    $data = array(
                        'id' => $id,
                        'mess' => $mess,
                        'bookDetail' => $bookIdSearch
                    );
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - lưu vào mảng data
            $data = array(
                'messError' => $mess,
            );
           
        }
        // - trả về view và data
        $this->template->title = 'book master';
        $this->template->content = View::forge('bookmaster/index',$data);
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: udpate
    public function action_update(){
        $data = array();
        try{
            if(input::post('btn-update')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){   
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');     
                    // - thông báo
                    $mess = Controller_Bookmaster::$messAge['MSG0014'];
                    // - lưu vào mảng data: id và thông báo
                    $data = array(
                        'id' => $id,
                        'messError' => $mess
                    );
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
                    // - lưu vào mảng data
                    $data = array(
                        'id' => $id,
                        'bookDetail' => $dataBook,
                        'mess' => $mess
                    );
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - lưu vào mảng data
            $data = array(
                'messError' => $mess,
            );
        }
        // - trả về view và data
        $this->template->title = 'book master';
        $this->template->content = View::forge('bookmaster/index',$data);  
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - function: xóa
    public function action_delete(){
        $data = array();
        try{
            if(input::post('btn-delete')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // - lấy id người dùng nhập
                    $id = input::post('bookId');
                    // - thông báo lỗi 
                    $mess = Controller_Bookmaster::$messAge['MSG0014'];
                    // - lưu vào mảng data
                    $data = array(
                        'id' => $id,
                        'messError' => $mess
                    );
                }else{
                    // - lấy id cần xóa
                    $id = input::post('bookId');
                    // - hàm xóa từ model
                    Model_Bookmaster::db_delete($id);
                    // - thông báo success
                    $mess = Controller_Bookmaster::$messAge['MSG0015'];
                    // - lưu vào mảng data
                    $data = array(
                        'id'=> $id,
                        'mess' => $mess
                    );
                }
            }
        }catch (Exception $e)
        {
            // - thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = Controller_Bookmaster::$messAge['MSG005'];
            // - lưu vào mảng data
            $data = array(
                'messError' => $mess
            );
        }
        // - trả về view và data
        $this->template->title = 'book master';
        $this->template->content = View::forge('bookmaster/index',$data);
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // - xử lí chức năng close
    public function action_thank(){
        $data = array();
        $this->template->title = 'Thanks';
        $this->template->content = View::forge('bookmaster/thank', $data);
    }   

   
}
