<?php
class Controller_Bookmaster extends Controller_Template
{
	
	public function action_index()
	{
        $books = Model_Bookmaster::find('all');
        $data = array('books' => $books);


        // xử lí thêm -----------------------------------------------BEGIN
        if(input::post('btn-add')){

            $year = input::post('year');
            $month = input::post('month');
            $day = input::post('day');
            

            $book = new Model_Bookmaster();
            $book->id = input::post('bookId');
            $book->book_title = input::post('bookTitle');
            $book->author_name = input::post('authorName');
            $book->publisher = input::post('publisher');
           
            $book->insert_day = date('y-m-d');
            
            $bookId = $book->id;

           

            // validation:::::::::::
            $val = Validation::forge();
    
            $val->add_field('bookId','Book Id','required');
            $val->add_field('bookTitle','Book Title','required');
            $val->add_field('authorName','Author Name','required');
            $val->add_field('publisher','Publisher','required');
            $val->add_field('year','Năm','required');
            $val->add_field('month','Tháng','required');
            $val->add_field('day','Ngày','required');
            if ($val->run())
            {
                // kiểm tra id tồn tại trong mảng
                if(array_key_exists($bookId,$books)){
                    $message = "Book Id đã tồn tại";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }else{
                    $d = mktime(0,0,0,$month,$day,$year);
                    $book->publication_day = date('y-m-d',$d);
                    $message = "Thêm thành công";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    $book->save();  
                }
            }
            else
            {  
                $mess = $val->error();
                $data = array("mess" => $mess);
                $this->template->content = View::forge('bookmaster/index', $data); 
            }
            // - - --  - -  - - - -  - - - - - -  - - -- 
            

                 
        }
        // kết thúc xử lý thêm -------------------------------------END
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // tra cứu --------------------------------------------------BEGIN

        if(input::post('btn-search')){
 
            $book = new Model_Bookmaster();
            $book->id = input::post('bookId');
            
            $bookIdSearch = Model_Bookmaster::find($book->id);

            if(in_array($bookIdSearch,$books)){
                $data = array("bookIdSearch" => $bookIdSearch);
                $this->template->content = View::forge('bookmaster/index', $data);  
            }else{
                $message = "Không tìm thấy book id";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }


    
             

        }
        // kết thúc tra cứu --------------------------------------------------END
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // update --------------------------------------------------BEGIN
        if(input::post('btn-update')){
            

            $val = Validation::forge();
    
            $val->add_field('bookId','Book Id','required');
            $val->add_field('bookTitle','Book Title','required');
            $val->add_field('authorName','Author Name','required');
            $val->add_field('publisher','Publisher','required');
            $val->add_field('year','Năm','required');
            $val->add_field('month','Tháng','required');
            $val->add_field('day','Ngày','required');

            if ($val->run())
            {

                $year = input::post('year');
                $month = input::post('month');
                $day = input::post('day');
           

                $book = Model_Bookmaster::find(input::post('bookId'));
                $book->id = input::post('bookId');
                $book->book_title = input::post('bookTitle');
                $book->author_name = input::post('authorName');
                $book->publisher = input::post('publisher');
           
                $book->update_day = date('y-m-d');   

                if(array_key_exists($book->id,$books)){
                    $d = mktime(0,0,0,$month,$day,$year);
                    $book->publication_day = date('y-m-d',$d);
                    $message = "Update thành công";
    
                    echo "<script type='text/javascript'>alert('$message');</script>";
        
                    $book->save();
                }else{
                    $message = "Id không tồn tại";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }else{
                $mess = $val->error();
                $data = array("mess" => $mess);
                $this->template->content = View::forge('bookmaster/index', $data);
            }

            

            
             
        }
        // kết thúc update --------------------------------------------------end
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // Xóa --------------------------------------------------Begin
        if(input::post('btn-delete')){

            $val = Validation::forge();
    
            $val->add_field('bookId','Book Id','required');
            $val->add_field('bookTitle','Book Title','required');
            $val->add_field('authorName','Author Name','required');
            $val->add_field('publisher','Publisher','required');
            $val->add_field('year','Năm','required');
            $val->add_field('month','Tháng','required');
            $val->add_field('day','Ngày','required');

            if ($val->run())
            {
                $year = input::post('year');
                $month = input::post('month');
                $day = input::post('day');
           

                $book = Model_Bookmaster::find(input::post('bookId'));
                $book->id = input::post('bookId');
                $book->book_title = input::post('bookTitle');
                $book->author_name = input::post('authorName');
                $book->publisher = input::post('publisher');
           
                $book->update_day = date('y-m-d');   

                if(array_key_exists($book->id,$books)){
                    $d = mktime(0,0,0,$month,$day,$year);
                    $book->publication_day = date('y-m-d',$d);
                    $message = "Xóa thành công";

                    echo "<script type='text/javascript'>alert('$message');</script>";
        
                    $book->delete();
                }else{
                    $message = "Id không tồn tại";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }else{
                $mess = $val->error();
                $data = array("mess" => $mess);
                $this->template->content = View::forge('bookmaster/index', $data);
            }


        }
        // kết thúc Xóa --------------------------------------------------end
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 
        // Clear --------------------------------------------------Begin
      
        
        if(input::post('btn-clear')){
            
       
            $bookIdSearch = new Model_Bookmaster();
            $bookIdSearch->id = '';
            $bookIdSearch->book_title = '';
            $bookIdSearch->author_name = '';
            $bookIdSearch->publisher = '';
            $bookIdSearch->publication_day = date('y-m-d');
            

            $data = array("bookIdSearch" => $bookIdSearch);
            $this->template->content = View::forge('bookmaster/index', $data);  
          
           

        }
        // sử dụng jquery---------------------------------kết thúc
        //- - - - - - - - - -  - - - - - - -  - - - - - - - - 


        $this->template->title = 'Book master';
        $this->template->content = View::forge('bookmaster/index', $data);
	}


    
        
    public function action_thank(){

        $data = array();
        $this->template->title = 'Thanks';
        $this->template->content = View::forge('bookmaster/thank', $data);
        // die('cảm ơn');
    }
   

}
?>