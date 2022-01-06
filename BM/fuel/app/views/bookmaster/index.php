
<div id="form-main-book">
        <div class="container">
            <div class="title-id">
                <h1>本マスタメンテ</h1>
                <a href="bookmaster/thank">閉じる</a>
            </div>
            <?php if(isset($mess)) { ?>
                <div class = "issetAlert"></div>
                    <div class="alert hide" style="border-left: 8px solid #00FF7F;">
                        <span class="fas fas fa-check-circle" style="color: #00FF7F;"></span>
                        <span class="msg">Success: <?php if(isset($id)) echo $id ?> <?php echo $mess?></span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                </div>
            <?php }?>
            <?php if(isset($messError)) { ?>
                <div class = "issetAlert"></div>
                    <div class="alert hide" style="border-left: 8px solid #FF0000;">
                        <span class="fas fa-exclamation-circle" style="color: #FF0000;"></span>
                        <span class="msg">Error: <?php if(isset($id)) echo $id ?> <?php echo $messError?></span>
                        <div class="close-btn">
                            <span class="fas fa-times"></span>
                        </div>
                </div>
            <?php }?>
            <!--  -->
            <?php 
            echo Form::open(array('action' => '', 'method' => 'post','id'=>'formBookSearch','onsubmit'=>'return onsubmitform();')); 
            ?>  
           <?php
                echo Form::label('本ID：', 'bookId'); 
            ?>
            <div class="form-group">
                <div class="searchId">
                <?php  
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
            
            echo Form::open(array('action' => '', 'method' => 'post','id'=>'formBook','onsubmit'=>'return onsubmitform();')); 
            ?>  
            <!-- --------------------------------- -->
           <?php
                echo Form::input('bookId', isset($id) ? $id :  (isset($book) ? $book->id : ''), array('type'=>'hidden'));
           ?>
            <!-- -------------------------------------- -->
            <div class="form-group">
            <?php  
                echo Form::label('本タイトル：', 'bookTitle');
                echo Form::input('bookTitle', isset($bookIdSearch) ? $bookIdSearch['book_title'] : (isset($book) ? $book->bookTitle : ''), array('placeholder' => 'Tiêu đề','id' => 'bookTitle'));      
            ?>
                <span class="form-message"></span>
            </div>
            
            <!-- --------------------------- -->
            <div class="form-group">
            <?php 
                echo Form::label('著者名：', 'authorName');
                echo Form::input('authorName', isset($bookIdSearch) ? $bookIdSearch['author_name'] : (isset($book) ? $book->authorName : ''), array('placeholder' => 'Tên tác giả', 'id' => 'authorName'));     
            ?>
                <span class="form-message"></span>
            </div>
           
             <!-- --------------------------- -->
            <div class="form-group">
            <?php  
                echo Form::label('出版社：', 'publisher');
                echo Form::input('publisher', isset($bookIdSearch) ? $bookIdSearch['publisher'] : (isset($book) ? $book->publisher : ''), array('placeholder' => 'Nhà xuất bản', 'id' => 'publisher'));          
            ?>
                <span class="form-message"></span>
            <div>
            <!-- ------------------------------ -->
            <div class="form-group">
                <?php 
                    echo Form::label('出版年月日：', 'publicationDay');
                ?>
                <div class="date">
                <?php
                    echo Form::input('year', isset($bookIdSearch) ? idate('Y',strtotime($bookIdSearch['publication_day'])) : (isset($book) ? $year : ''), array('placeholder' => 'YY','id'=>'year'));
                    echo Form::label('年', 'year');
                ?>

                <?php
                    echo Form::input('month', isset($bookIdSearch) ? idate('m',strtotime($bookIdSearch['publication_day'])) : (isset($book) ? $month : ''), array('placeholder' => 'MM','id'=>'month')); 
                    echo Form::label('月', 'month');
                ?>
                <?php
                    echo Form::input('day', isset($bookIdSearch) ? idate('d',strtotime($bookIdSearch['publication_day'])) : (isset($book) ? $day : ''), array('placeholder' => 'DD','id'=>'day')); 
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
                            if(isset($bookIdSearch)){
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
                document.myform.action ="<?php Controller_Bookmaster::addBook(); ?>";
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
        if ($(".issetAlert")[0]){
            $('.alert').addClass("show");
            $('.alert').removeClass("hide");
            $('.alert').addClass("showAlert");
            setTimeout(function(){
               $('.alert').removeClass("show");
               $('.alert').addClass("hide");
            },3000);
         }
         $('.close-btn').click(function(){
           $('.alert').removeClass("show");
           $('.alert').addClass("hide");
         });
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
