<?php
class Controller_Bookmaster extends Controller_Template
{
	public function action_index()
	{  	
        $messAge = [
            'MSG001'=> "Vui lòng nhập id của sách",
            'MSG002'=> "Hãy nhập Book ID bằng chữ số 1 byte",
            'MSG003'=>"Sách đã được tìm thấy",
            'MSG004'=> "Không thể tìm thấy Book ID****",
            'MSG005'=> "Đã phát sinh ngoại lệ bằng xử lý server",
            'MSG006'=> "Hãy nhập Book title",
            'MSG007'=> "Hãy nhập tên tác giả",
            'MSG008'=> "Hãy nhập nhà xuất bản",
            'MSG009'=> "Hãy nhập ngày xuất bản",
            'MSG0010'=> "Hãy nhập ngày xuất bản bằng chữ số 1 byte",
            'MSG0011'=> "Book ID****đã được đăng ký. Hãy nhập ID khác",
            'MSG0012'=> "Đã đăng ký sách",
            'MSG0013'=> "Đã update sách",
            'MSG0014'=> "Book ID****không được tìm thấy",
            'MSG0015'=> "Đã xóa Book ID****",
            'MSG0016'=> "Ngày xuất bản không hợp lệ",
        ];
        $data = array();
        try
        {
            // xử lí thêm -----------------------------------------------BEGIN
            if(input::post('btn-add')){        
                //lấy thông tin người dùng nhập vào
                $book = new Model_Bookmaster();
                $book->id = input::post('bookId');
                $book->book_title = input::post('bookTitle');
                $book->author_name = input::post('authorName');
                $book->publisher = input::post('publisher');
                $book->insert_day = date('y-m-d H:m:s');

                $year = input::post('year');
                $month = input::post('month');
                $day = input::post('day');
                $d = mktime(0,0,0,$month,$day,$year);
                $book->publication_day = date('y-m-d',$d);
            
                // kiểm tra id tồn tại trong mảng
                $getBookId = Model_Bookmaster::getBookId();
                if(array_search(input::post('bookId'), array_column($getBookId, 'id')) !== false) {
                    $mess = $messAge['MSG0011'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
                }
                else {
                    $mess = $messAge['MSG0012'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 

                    $book->save();  
                }
                // - - --  - -  - - - -  - - - - - -  - - --  
            }
      
            // kết thúc xử lý thêm -------------------------------------END
            //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
            // tra cứu --------------------------------------------------BEGIN
            if(input::post('btn-search')){
           
                $getBookId = Model_Bookmaster::getBookId();
                // kiểm trả id tồn tại mảng trong mảng
                if(array_search(input::post('bookId'), array_column($getBookId, 'id')) !== false) {
                    // lấy chi tiết sách
                    $bookIdSearch = Model_Bookmaster::getDetailbook(input::post('bookId'));

                    // thông báo
                    $mess = $messAge['MSG003'];
                    $data = array("bookIdSearch" => $bookIdSearch,'mess'=> $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
                }
                else {
                    // thông báo
                    $mess = $messAge['MSG004'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
                }
            }
       
        
            // kết thúc tra cứu --------------------------------------------------END
            //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
            // update --------------------------------------------------BEGIN
            if(input::post('btn-update')){
                 
                $getBookId = Model_Bookmaster::getBookId();
                // kiểm trả id tồn tại mảng trong mảng
                if(array_search(input::post('bookId'), array_column($getBookId, 'id')) !== false) {
                    // lấy cập nhật từ người dùng nhập vào
                    $book = Model_Bookmaster::find(input::post('bookId'));
                    $book->book_title = input::post('bookTitle');
                    $book->author_name = input::post('authorName');
                    $book->publisher = input::post('publisher');

                    $year = input::post('year');
                    $month = input::post('month');
                    $day = input::post('day');
                    $d = mktime(0,0,0,$month,$day,$year);
                    $book->publication_day = date('y-m-d',$d);
           
                    $book->update_day = date('y-m-d H:m:s');  

                    // thông báo
                    $mess = $messAge['MSG0013'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 


                    // cập nhật
                    $book->save();
                }
                else {
                    // thông báo
                    $mess = $messAge['MSG0014'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
                }
            }
            // kết thúc update --------------------------------------------------end
            //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
            // Xóa --------------------------------------------------Begin
            if(input::post('btn-delete')){

                $getBookId = Model_Bookmaster::getBookId();
                // kiểm trả id tồn tại mảng trong mảng
                if(array_search(input::post('bookId'), array_column($getBookId, 'id')) !== false) {
                    // lấy chi tiết sách 
                    $book = Model_Bookmaster::find(input::post('bookId'));

                    // thông báo
                    $mess = $messAge['MSG0015'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
        
                    // xóa
                    $book->delete();
                }
                else {
                    // thông báo 
                    $mess = $messAge['MSG0014'];
                    $data = array("mess" => $mess);
                    $this->template->content = View::forge('bookmaster/index', $data); 
                }
            }
            // kết thúc Xóa --------------------------------------------------end
            //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
            // Clear --------------------------------------------------Begin
            // sử dụng jquery---------------------------------kết thúc
            //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        }
        catch (Exception $e)
        {
            // thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = $messAge['MSG005'];
            $data = array("mess" => $mess);
            $this->template->content = View::forge('bookmaster/index', $data); 
        }
        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data);
	}
    public function action_thank(){
        $data = array();
        $this->template->title = 'Thanks';
        $this->template->content = View::forge('bookmaster/thank', $data);
    }   


   
}
