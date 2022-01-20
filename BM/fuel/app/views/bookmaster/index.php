<?php
Controller_Bookmaster::addBook();
Controller_Bookmaster::searchId();
Controller_Bookmaster::updateBook();
Controller_Bookmaster::deleteBook();
?>
<div id="form-main-book">
        <div class="container">
            <div class="title-id">
                <h1>本マスタメンテ</h1>
                <a href="bookmaster/thank">閉じる</a>
            </div>
            <?php if(Session::get_flash('mess')) { ?>
                <div class = "issetAlert"></div>
                    <div class="alert hide" style="border-left: 8px solid #00FF7F;">
                        <span class="fas fas fa-check-circle" style="color: #00FF7F;"></span>
                        <span class="msg">Success: <?php if(Session::get_flash('id')) echo Session::get_flash('id'); ?> <?php echo Session::get_flash('mess')?></span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                </div>
            <?php }?>
            <?php if(Session::get_flash('messError')) { ?>
                <div class = "issetAlert"></div>
                    <div class="alert hide" style="border-left: 8px solid #FF0000;">
                        <span class="fas fa-exclamation-circle" style="color: #FF0000;"></span>
                        <span class="msg">Error: <?php if(Session::get_flash('id')) echo Session::get_flash('id'); ?> <?php echo Session::get_flash('messError');?></span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                </div>
            <?php }?>
            <!--  -->
            <?php 
            echo Form::open(array('action' => '/', 'method' => 'post','id'=>'formBookSearch','onsubmit'=>'return onsubmitform();')); 
            ?>  
           <?php
                echo Form::label('本ID：', 'bookId'); 
            ?>
            <div class="form-group">
                <div class="searchId">
                <?php  
                    $id = Session::get_flash('id');
                    echo Form::input('bookId', isset($id) ? $id : (isset($book) ? $book->id : ''), array('placeholder' => 'Id','id'=>'bookId','onChange'=>'upperMe();'));      
                    echo Form::submit('btn-search', '検索', array(
                        'class' => 'btn-search','onclick'=>'document.pressed=this.value')); 
                 ?>
                </div>
                <span class="form-message"></span>
                
            </div>
            <?php 
            echo Form::close(); 
            ?>    
            <!--  -->
           
            <!-- ------------------------ -->
            <?php 
            
            echo Form::open(array('action' => '/', 'method' => 'post','id'=>'formBook','onsubmit'=>'return onsubmitform();')); 
            ?>  
            <!-- --------------------------------- -->
           <?php
                $id = Session::get_flash('id');
                echo Form::input('bookId', isset($id) ? $id :  (isset($book) ? $book->id : ''), array('type'=>'hidden'));
           ?>
            <!-- -------------------------------------- -->
            <div class="form-group">
            <?php
                $book_title = Session::get_flash('book_title');
                echo Form::label('本タイトル：', 'bookTitle');
                echo Form::input('bookTitle', isset($book_title) ? $book_title : (isset($book) ? $book->bookTitle : ''), array('placeholder' => 'Tiêu đề','id' => 'bookTitle'));      
            ?>
                <span class="form-message"></span>
            </div>
            
            <!-- --------------------------- -->
            <div class="form-group">
            <?php 
                $author_name = Session::get_flash('author_name');
                echo Form::label('著者名：', 'authorName');
                echo Form::input('authorName', isset($author_name) ? $author_name : (isset($book) ? $book->authorName : ''), array('placeholder' => 'Tên tác giả', 'id' => 'authorName'));     
            ?>
                <span class="form-message"></span>
            </div>
           
             <!-- --------------------------- -->
            <div class="form-group">
            <?php  
                $publisher = Session::get_flash('publisher');
                echo Form::label('出版社：', 'publisher');
                echo Form::input('publisher', isset($publisher) ? $publisher : (isset($book) ? $book->publisher : ''), array('placeholder' => 'Nhà xuất bản', 'id' => 'publisher'));          
            ?>
                <span class="form-message"></span>
            <div>
            <!-- ------------------------------ -->
            <div class="form-group">
                <?php
                    $publication_day = Session::get_flash('publication_day'); 
                ?>
                <?php
                    
                    echo Form::label('出版年月日：', 'publicationDay');
                ?>
                <div class="date">
                <?php
                    echo Form::input('year', isset($publication_day) ? idate('Y',strtotime($publication_day)) : (isset($book) ? $year : ''), array('placeholder' => 'YY','id'=>'year'));
                    echo Form::label('年', 'year');
                ?>

                <?php
                    echo Form::input('month', isset($publication_day) ? idate('m',strtotime($publication_day)) : (isset($book) ? $month : ''), array('placeholder' => 'MM','id'=>'month')); 
                    echo Form::label('月', 'month');
                ?>
                <?php
                    echo Form::input('day', isset($publication_day) ? idate('d',strtotime($publication_day)) : (isset($book) ? $day : ''), array('placeholder' => 'DD','id'=>'day')); 
                    echo Form::label('日', 'day');
                ?>
                </div>
                <span class="form-message"></span>
            </div>
            <div class="clearfix">
                <div class="btn-form">
                    <?php
                        echo Form::submit('btn-add', '追加', array(
                            'class' => 'btn-add','onclick'=>'document.pressed=this.value'));  
                        echo Form::submit('btn-update', '更新', array(
                            'class' => 'btn-update','onclick'=>'document.pressed=this.value'));  
                        echo Form::submit('btn-delete', '削除', array(
                            'class' => 'btn-delete','onclick'=>'document.pressed=this.value'));  
                    ?>
                    <input type="submit" name="btn-clear" class="btn-clear" value="クリア" <?php 
                            if(Session::get_flash('id') || Session::get_flash('book_title') || Session::get_flash('author_name') || Session::get_flash('publisher') || Session::get_flash('publication_day')){
                                echo "onclick = ''";
                            }else {
                                echo "onclick = 'return false;'";
                            }
                    ?>/>
                </div>
            </div>
         </div>
        <?php 
            echo Form::close(); 
        ?>     
         </div>
    </div>
    <script>
        function OnSubmitForm()
        {
            if(document.pressed == '追加')
            {
                return document.myform.action ="<?php Controller_Bookmaster::addBook(); ?>";
            }else
            if(document.pressed == '検索')
            {
                document.myform.action ="<?php Controller_Bookmaster::searchId(); ?>";
            }
            else
            if(document.pressed == '更新')
            {
                document.myform.action ="<?php Controller_Bookmaster::updateBook(); ?>";
            }
            else
            if(document.pressed == '削除')
            {
                document.myform.action ="<?php Controller_Bookmaster::deleteBook(); ?>";
            }
            return true;
        }
        Validator({      
            form: '#formBookSearch',
            formGroupSelector: '.form-group',
            errorSelector: ".form-message",
            rules: [
                Validator.isRequired('#bookId', arrMessage.MSG001),
                Validator.maxLength('#bookId', 4),
                Validator.isBookId('#bookId', arrMessage.MSG002),
            ],
        });
        Validator({      
            form: '#formBook',
            formGroupSelector: '.form-group',
            errorSelector: ".form-message",
            rules: [
                Validator.isRequired('#bookTitle',arrMessage.MSG006),
                Validator.maxLength('#bookTitle', 40),

                Validator.isRequired('#authorName' , arrMessage.MSG007),
                Validator.maxLength('#authorName', 40),

                Validator.isRequired('#publisher',arrMessage.MSG008),
                Validator.maxLength('#publisher', 40),  


                Validator.isRequired('#year',arrMessage.MSG009),
                Validator.maxNumber('#year', 2021, arrMessage.MSG0016),
                Validator.isYear('#year', arrMessage.MSG0010),

                Validator.isRequired('#month',arrMessage.MSG009),
                Validator.maxNumber('#month', 12, arrMessage.MSG0016),
                Validator.isMonth('#month', arrMessage.MSG0010),

                Validator.isRequired('#day',arrMessage.MSG009),
                Validator.maxNumber('#day', 31, arrMessage.MSG0016),
                Validator.isDay('#day', arrMessage.MSG0010),
            ],
        });
    </script>
