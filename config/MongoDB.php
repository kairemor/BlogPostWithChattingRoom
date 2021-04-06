<?php
    session_start(); 
    require('./vendor/autoload.php'); 

    class MongoDB{
        function __construct(){
            $this->db = (new MongoDB\Client("mongodb://ugb6g73j585gpzjzfidk:Xix2nhQ3Y6yxLR3jbeI6@bfwljddhhprbyaz-mongodb.services.clever-cloud.com:27017/bfwljddhhprbyaz"))->bfwljddhhprbyaz;
	    #$this->db = new MongoDB\Driver\Manager("mongodb://localhost:27017"); 
	    #$this->db = (new MongoDB\Client("mongodb://bfwljddhhprbyaz-mongodb.services.clever-cloud.com:27017", array("username" => "ugb6g73j585gpzjzfidk", "password" => "Xix2nhQ3Y6yxLR3jbeI6")))->bfwljddhhprbyaz;
	}
        
        public function register($data = []){ 
            extract($data) ; 
            $now = date('Y-m-d H:i:s');
            $this->col = $this->db->users ; 
            
            if (empty($data)){
                return false ;
            }
            $result = $this->col->findOne($filter=['username' => $username]); 
            if (isset($result)){
                $_SESSION['register_username'] = 'Username already taken'; 
                return false ; 
            }
            if($password != $confirmPassword) {
                $_SESSION['register_pwd_match'] = 'Password are not the same' ; 
                return false ; 
            }
            $hash = password_hash($password, PASSWORD_BCRYPT) ; 
            $insertable = $this->col->insertOne([
                'firstname' => $firstname , 
                'lastname' => $lastname,
                'username' => $username,
                'email' => $email,
                'hash' => $hash,
                'join_us' => $now,  
                'image' => ''
            ]); 
            $_SESSION['register'] = 'Inscription reussi' ;
            return $insertable->getInsertedId();
        }

        public function login($data){
            extract($data); 
            $this->col = $this->db->users ; 
            $username = $this->col->findOne($filter = ['username'=> $username]); 
            if(isset($username)){
                if (password_verify($password, $username->hash)){
                    $_SESSION['username'] = $username->username ; 
                    header('Location: ../index.php') ;
                }else{
                    $_SESSION['pwd_login_err'] = "Wrong password !!!"; 
                }
            }else{
                $_SESSION['username_login_err'] = "Wrong username !!!"; 
                }
            }

        public  function getPost($number){
            $this->col = $this->db->post; 
            $allpost = $this->col->find(
                [],
                [
                    'sort' => ['create_at' => -1 ], 
                    'limit' => $number , 
                ]
            );  
            return  $allpost ; 
        }

        public function setPost($data, $file){
            extract($data); 
            $now = date('Y-m-d H:i:s'); // new Mongo\BSON\UTCDateTime
            $this->col = $this->db->post ; 
            if($file['image']){
                $name = $file['image']['name'] ; 
                $tmp = $file['image']['tmp_name']; 
                $local = 'uploads/'; 
                move_uploaded_file($tmp, $local.$name); 
                $img_upload = $local.''.$name ; 
                }

            $insertable = $this->col->insertOne([
                'user' => $_SESSION['username'],
                'title' => $title ,
                'subtitle' => $subtitle ,
                'content' => $content,
                'create_at' => $now ,
                'images' => $img_upload ,
                'likes' => [], 
                'views_number' => 0,
                'comments' => []  
            ]);
            header("Location: ../index.php#main_content") ; 
            return $insertable->getInsertedId(); 
        }

        public function getOne($id){
            $this->col = $this->db->post ; 

            $post = $this->col->findOne(['_id' => new MongoDB\BSON\ObjectID($id)]);

            return $post ; 
        }

        public function addView($id){
            $view =  $this->col->findOne(['_id' => new MongoDB\BSON\ObjectID($id)])->views_number; 
            $this->col = $this->db->post ; 
            $view_user = $_SESSION['username'].''.$id ; 
            if (!isset($_SESSION[$view_user])){
                $this->col->findOneAndUpdate(['_id' => new MongoDB\BSON\ObjectID($id)],[
                    '$set' => ['views_number' => $view+1]  
                ]); 
                $_SESSION[$view_user] = TRUE ; 
            }
            $view =  $this->col->findOne(['_id' => new MongoDB\BSON\ObjectID($id)])->views_number;
            return $view ;
        }

        public function getComments($id){
            $this->col = $this->db->post ; 
            $allComment = $this->col->findOne(['_id' => new MongoDB\BSON\ObjectID($id)])->comments;
            
            return $allComment ; 
        } 

        public function addComment($id, $data){
            $this->col = $this->db->post ;
            $now = date('Y-m-d H:i:s');

            $this->col->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($id)],
                ['$push' => ['comments' => 
                    [
                        'user' => $_SESSION['username'],
                        'comment' => $data['comment'],
                        'create_at' => $now 
                    ]
                    ]
                ]
            ); 
        }

        public function getMessages($n=100){
            $this->col = $this->db->message ; 
            $messages = $this->col->find([],[
                'limit' => $n ,
            ]); 
            return $messages;  
        }

        public function setMessage($data){
            $this->col_user = $this->db->users ;
            $this->col = $this->db->message ;
            $image = $this->col_user->findOne(['username' => $_SESSION['username']])->image ;  
            $now = date('Y-m-d H:i:s');
            $newmsg = $this->col->insertOne([
                'user' => $_SESSION['username'], 
                'message' => $data['message'], 
                'create_at' => $now,
                'user_image' => $image,  
            ]); 
            return $newmsg ; 
        }

        public function deletePost($id){
            $this->col = $this->db->post ;
            $deletedOne = $this->col->findOneAndDelete(['_id' => new MongoDB\BSON\ObjectID($id)]);  
            $_SESSION['delete_post'] = TRUE ; 
        }
        public function updatePost($id , $data, $file){
            extract($data); 
            $this->col = $this->db->post ;
            $now = date('Y-m-d H:i:s');
            if($file['image'] && $file['image']['name']!=null){
                $name = $file['image']['name'] ; 
                $tmp = $file['image']['tmp_name']; 
                $local = 'uploads/'; 
                move_uploaded_file($tmp, $local.$name); 
                $img_upload = $local.''.$name ; 
                }
            if(isset($img_upload)){
                $update = $this->col->findOneAndUpdate(['_id' =>  new MongoDB\BSON\ObjectID($id)],
                ['$set' => [
                    'user' => $_SESSION['username'],
                    'title' => $title ,
                    'subtitle' => $subtitle ,
                    'content' => $content,
                    'update_at' => $now ,
                    'images' => $img_upload
                ]]); 
            }else{
                $update = $this->col->findOneAndUpdate(['_id' =>  new MongoDB\BSON\ObjectID($id)],
                ['$set' => [
                    'user' => $_SESSION['username'],
                    'title' => $title ,
                    'subtitle' => $subtitle ,
                    'content' => $content,
                    'update_at' => $now ,
                ]]);    
            }
        }
        public function myPost(){
            $this->col = $this->db->post ;
            $myposts = $this->col->find(['user' => $_SESSION['username']],
            [
                'sort' => ['create_at' => -1]
            ]); 
            return $myposts ; 
        }

        public function getUser($username){
            $this->col = $this->db->users; 
            $user = $this->col->findOne(['username' => $username]); 
            return $user ;
        }

        public function update_user($username, $data, $file){
            extract($data); 
            $this->col = $this->db->users ;
            $now = date('Y-m-d H:i:s');
            if($file['image']){
                $name = $file['image']['name'] ; 
                $tmp = $file['image']['tmp_name']; 
                $local = 'uploads/'; 
                move_uploaded_file($tmp, $local.$name); 
                $img_upload = $local.''.$name ; 
                }
            $update = $this->col->findOneAndUpdate(['username' =>  $username],
                ['$set' => [
                    'firstname' => $firstname, 
                    'lastname' => $lastname ,
                    'image' => $img_upload, 
                    'update_at' => $now ,
                ]],['new' => true]); 
            return $update  ;
        }

        public function likePost($user, $id){
            $this->col = $this->db->post ;
            $result = $this->col->findOne(['_id' => new MongoDB\BSON\ObjectID($id), 'likes' => $user]);  
            if($result !== null){
                return true;
            }else{
                return false; 
            }
        }

        public function addLike($user, $id){
            $this->col = $this->db->post;
            $this->col->findOneAndUpdate(
                ['_id' =>  new MongoDB\BSON\ObjectID($id)],
                ['$push' => ['likes' => $user]]); 
        }

        public function deleteLike($user, $id){
            $this->col = $this->db->post;
            $this->col->findOneAndUpdate(
                ['_id' =>  new MongoDB\BSON\ObjectID($id)],
                ['$pull' => ['likes' => $user]]); 

        }

        public function likeNumber($id){
            $user_like = []; 
            $this->col = $this->db->post; 
            $likes = $this->col->findOne(['_id'=> new MongoDB\BSON\ObjectID($id)])->likes ; 
            foreach ($likes as $like) {
                array_push($user_like, $like); 
            }
            return sizeof($user_like) ; 
        }

        public function mostLike(){
            $most_liked = []; 
            $this->col = $this->db->post;
            $posts = $this->col->find(
                [],
                [
                    'sort' => ['views_number' => -1 ], 
                    'limit' => 10 , 
                ]); 
            foreach($posts as $post){
                $like_number = $this->col->likeNumber($post->_id); 
                // array_push($most_liked, $li); 
                $most_like[$post->title] = $like_number ;   
            }
        }
        public function mostView(){
            $most_views = []; 
            $views_final = []; 
            $this->col = $this->db->post;
            $posts = $this->col->find(
                [],
                [
                    'sort' => ['views_number' => -1 ], 
                    'limit' => 10 , 
                ]); 
            foreach($posts as $post){
                $most_views["title"] = $post->title;  
                $most_views["number"] = $post->views_number ; 
                array_push($views_final, $most_views); 
            }
            return $views_final ; 
        }
    }
?>
