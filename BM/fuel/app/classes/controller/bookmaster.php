<?php
class Controller_Bookmaster extends Controller_Template
{
    public $messAge = array(
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
    );

	public function action_index()
	{  	
        $data = array();
        // xử lí thêm -----------------------------------------------BEGIN
        $Add = $this->addBook();
        if(is_array($Add)){
            $data = array('mess'=> $Add[0]);
        }
        // kết thúc xử lý thêm -------------------------------------END
        
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // tra cứu --------------------------------------------------BEGIN
        $search = $this->searchId();
        if(is_array($search)){
            if(count($search) == 2){
                $data = array('mess'=>$search[0],'bookIdSearch' => $search[1]);
            }else {
                $data = array('mess' => $search[0]);
            }
           
        }
        // kết thúc tra cứu --------------------------------------------------END

        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // update --------------------------------------------------BEGIN
        $update = $this->updateBook();
        if(is_array($update)){
            if(count($update) == 2){
                $data = array('mess'=>$update[0],'bookIdSearch' => $update[1]);
            }else {
                $data = array('mess'=> $update[0]);
            }
            
        }
        // kết thúc update --------------------------------------------------end
        
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // Xóa --------------------------------------------------Begin
        $delete = $this->deleteBook();
        if(is_array($delete)){
            $data = array('mess'=> $delete[0]);
        }
        // kết thúc Xóa --------------------------------------------------end

        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data);
	}

    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // fucntion thêm
    public function addBook(){
        try
        {
            if(input::post('btn-add')){        
                if(Model_Bookmaster::find(input::post('bookId')) === null){  
                    //lấy thông tin người dùng nhập vào
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
                    // thêm
                    Model_Bookmaster::db_insert($dataBook);

                    // trả về mảng thông báo
                    $mess = $this->messAge['MSG0012'];
                    return array($mess);
                }else{
                    // trả về mảng thông báo
                    $mess = $this->messAge['MSG0011'];
                    return array($mess);
                }
                // - - --  - -  - - - -  - - - - - -  - - --  
            }
        }catch (Exception $e)
        {
            // thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = $this->messAge['MSG005'];
            return array($mess);
        }
        

    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // function tìm kiếm
    public function searchId(){
        try{
            if(input::post('btn-search')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // thông báo
                    $mess = $this->messAge['MSG004'];
                    return array($mess);
                }else{
                    // lấy chi tiết sách
                    $bookIdSearch = Model_Bookmaster::getDetailbook(input::post('bookId'));
                    // thông báo
                    $mess = $this->messAge['MSG003'];
                    return array($mess,$bookIdSearch);
                }
            }
        }catch (Exception $e)
        {
            // thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = $this->messAge['MSG005'];
            return array($mess);
        }
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // function udpate
    public function updateBook(){
        try{
            if(input::post('btn-update')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){        
                    // thông báo
                    $mess = $this->messAge['MSG0014'];
                    return array($mess);
                }else {
                    // lấy cập nhật từ người dùng nhập vào
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
                    // cập nhật
                    Model_Bookmaster::db_update($dataBook,$id);

                    $bookIdSearch = Model_Bookmaster::getDetailbook(input::post('bookId'));
                    // thông báo
                    $mess = $this->messAge['MSG0013'];
                    return array($mess,$bookIdSearch);
                }
            }
        }catch (Exception $e)
        {
            // thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = $this->messAge['MSG005'];
            return array($mess);
        }
        
    }
    //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
    // function xóa
    public function deleteBook(){
        try{
            
            if(input::post('btn-delete')){
                if(Model_Bookmaster::find(input::post('bookId')) === null){
                    // thông báo 
                    $mess = $this->messAge['MSG0014'];
                    return array($mess);
                }else{
                     // lấy id cần xóa
                    $id = input::post('bookId');
                    // xóa
                    Model_Bookmaster::db_delete($id);
                    // thông báo
                    $mess = $this->messAge['MSG0015'];
                    return array($mess);
                }
            }
        }catch (Exception $e)
        {
            // thông báo trường hợp ngoại lệ liên quan đến DB error
            $mess = $this->messAge['MSG005'];
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
