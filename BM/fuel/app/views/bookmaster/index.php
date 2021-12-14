
<div id="form-main-book">
        
    
        <div class="container">
            <div class="title-id">
                <h1>本マスタメンテ</h1>
                <a href="bookmaster/thank">閉じる</a>
            </div>
           
            <!-- ------------------------ -->
            <?php 
            echo Form::open(array('action' => 'bookmaster/index', 'method' => 'post','id'=>'formBook')); 
            ?>  

            <!-- --------------------------------- -->
            <?php
                echo Form::label('本ID：', 'bookId'); 
            ?>
                <div class="searchId">
                <?php  
                 if(isset($bookIdSearch)){
                    echo Form::input('bookId', $bookIdSearch->id, array('placeholder' => 'Id','id'=>'bookId'));      
                     echo Form::submit('btn-search', '検索', array(
                            'class' => 'btn-search')); 
                }else{
                    echo Form::input('bookId', input::post('bookId',isset($book) ? $book->id : ''), array('placeholder' => 'Id','id'=>'bookId'));      
                    echo Form::submit('btn-search', '検索', array(
                    'class' => 'btn-search')); 
                }
                
                    
                 ?>
                
            </div>
            <!-- thông báo -->
            <?php
            if(isset($mess) && isset($mess['bookId']) ){
            ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php echo $mess['bookId']?>
                </div>
            <?php
            }
            ?>
    
            <!-- -------------------------------------- -->
            <?php  
                if(isset($bookIdSearch)){
                    echo Form::label('本タイトル：', 'bookTitle');
                    echo Form::input('bookTitle', $bookIdSearch->book_title, array('placeholder' => 'Tiêu đề'));      
                }else{
                    echo Form::label('本タイトル：', 'bookTitle');
                    echo Form::input('bookTitle', input::post('bookTitle',isset($book) ? $book->book_title : ''), array('placeholder' => 'Tiêu đề'));      
                }
                
                 
            ?>
            <?php
            if(isset($mess) && isset($mess['bookTitle']) ){
            ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php if(isset($mess['bookTitle'])) echo $mess['bookTitle']?>
                </div>
            <?php
            }
            ?>
            <!-- --------------------------- -->
            <?php  
                 if(isset($bookIdSearch)){
                    echo Form::label('著者名：', 'authorName');
                    echo Form::input('authorName', $bookIdSearch->author_name, array('placeholder' => 'Tên tác giả'));        
                 }else{
                    echo Form::label('著者名：', 'authorName');
                    echo Form::input('authorName', input::post('authorName',isset($book) ? $book->author_name : ''), array('placeholder' => 'Tên tác giả'));        
                 }
               
            ?>
            <?php
            if(isset($mess) && isset($mess['authorName']) ){
            ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php if(isset($mess['authorName'])) echo $mess['authorName']?>
                </div>
            <?php
            }
            ?>
             <!-- --------------------------- -->
            <?php  
                if(isset($bookIdSearch)){
                    echo Form::label('出版社：', 'publisher');
                    echo Form::input('publisher', $bookIdSearch->publisher, array('placeholder' => 'Nhà xuất bản'));        
                }else{
                    echo Form::label('出版社：', 'publisher');
                    echo Form::input('publisher', input::post('publisher',isset($book) ? $book->publisher : ''), array('placeholder' => 'Nhà xuất bản'));        
                }

                
            ?>
            <?php
            if(isset($mess) && isset($mess['publisher']) ){
            ?>
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php if(isset($mess['publisher'])) echo $mess['publisher']?>
                </div>
            <?php
            }
            ?>
            <!-- ------------------------------ -->
            <?php 
                echo Form::label('出版年月日：', 'publicationDay');
            ?>
            <div class="date">
                <?php
                if(isset($bookIdSearch)){
                    
                    
                    echo Form::input('year', '20'.idate('y',strtotime($bookIdSearch->publication_day)), array('type'=>'number','min'=> '1','max'=>'2099','placeholder' => 'YY'));
                    echo Form::label('年', 'year'); 
                }else{
                    
                    echo Form::input('year', input::post('year',isset($book) ? $year : ''), array('type'=>'number','min'=> '1','max'=>'2099','placeholder' => 'YY')); 
                    echo Form::label('年', 'year');
                }
                
                ?>

                <?php
                if(isset($bookIdSearch)){
                    
                    echo Form::input('month', idate('m',strtotime($bookIdSearch->publication_day)), array('type'=>'number','min'=> '1','placeholder' => 'MM')); 
                    echo Form::label('月', 'month');
                }else{
                    
                    echo Form::input('month', input::post('month',isset($book) ? $month : ''), array('type'=>'number','min'=> '1','placeholder' => 'MM')); 
                    echo Form::label('月', 'month');
                }
                
                ?>
                <?php
                if(isset($bookIdSearch)){
                    
                    echo Form::input('day', idate('d',strtotime($bookIdSearch->publication_day)), array('type'=>'number','min'=> '1','placeholder' => 'DD')); 
                    echo Form::label('日', 'day');
                }else{
                    
                    echo Form::input('day', input::post('day',isset($book) ? $day : ''), array('type'=>'number','min'=> '1','placeholder' => 'DD')); 
                    echo Form::label('日', 'day');
                }
                ?>
                <!-- thông báo -->
            </div>
            <?php
                if(isset($mess) && isset($mess['bookId']) ){
                ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                             <?php if(isset($mess['year'])) echo $mess['year']?>
                    </div>
                 <?php
            }
            ?>
            <?php
                if(isset($mess) && isset($mess['month']) ){
                ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                             <?php if(isset($mess['month'])) echo $mess['month']?>
                    </div>
                 <?php
            }
            ?>
            <?php
                if(isset($mess) && isset($mess['day']) ){
                ?>
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                             <?php if(isset($mess['day'])) echo $mess['day']?>
                    </div>
                 <?php
            }
            ?>
            <div class="clearfix">
                <div class="btn-form">
                    <?php
                        echo Form::submit('btn-add', '追加', array(
                            'class' => 'btn-add'));  
                        echo Form::submit('btn-update', '更新', array(
                            'class' => 'btn-update'));  
                        echo Form::submit('btn-delete', '削除', array(
                            'class' => 'btn-delete')); 
                        echo Form::submit('btn-clear', 'クリア', array(
                            'class' => 'btn-clear','onClick' => 'cleartext()'));  
                    ?>
                </div>
            </div>

         </div>
         <script>
             
         </script>
        <?php 
            echo Form::close(); 
         ?>     
         </div>
    </div>


    