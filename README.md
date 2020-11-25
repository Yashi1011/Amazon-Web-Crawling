# Amazon-Web-Crawling (Task-1)

## Working of the website

### Objective

A basic website that takes a key/search word as input and based on that it displays the product details(*title, image, price*) from amazon.

A sample walkthrough can be found [here.](https://drive.google.com/file/d/1UeUDDOzHRR5aK1TMHZBVDhavIZrMWfF7/view?usp=sharing)

- __index.html__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/index.PNG" width=700px>

- __login.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/login.PNG" width=700px>

- __register.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/register.PNG" width=700px>

- __forgotPassword.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/forgetpassword.PNG" width=700px>

- __user.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/user1.PNG" width=700px>
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/user2.PNG" width=700px>

- __contact.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/contact.PNG" width=700px>

- __admin.php__
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/admin1.PNG" width=700px>
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/admin2.PNG" width=700px>
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/admin3.PNG" width=700px>
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/admin4.PNG" width=700px>
<img src="https://github.com/Yashi1011/Amazon-Web-Crawling/blob/master/imgs/admin5.PNG" width=700px>

## Evaluation criteria:

- [x] __Create the first page (home/index page) along with five other web pages__
  - Created an `index.html` page with `login`, `register` and `Forget Password?` buttons.
  - Created other relevant pages (`.php` files)
    - login.php
    - register.php
    - user.php
    - contact.php
    - admin.php
    - forgot_password.php
  
- [x] __Effective use of color, images and font and proper page markup language__
  - Used CSS and bootstap 4
  
- [x] __Utility of html, CSS, javascript and any other languages in implementation__
  - Used `HTML` for constructing the site.
  - Used `CSS` for formatting and structuring the site.
  - Used `javascript` for making it interactive.
  - Used `Bootstrap`, a framework to customize the HTML elements even better.
  - Used `php`, for backend.
  
- [x] __Interactive features over the website like contact forms__
  - User can sent message/contact admins by filling the contact form in `user page`.
  - The messages are stored in database and displayed in admin pages.
  - The screenshot is given above.
 
- [x] __Validating the HTML code__
  - Validated my `index.html` file in [https://validator.w3.org/](https://validator.w3.org/) .
  
- [x] __User registration, Authentication and Page/Form Validation features across the website.
The admin user shall have different pages as compared to normal users. The admin user
can add new users to the system__
  - The user has to register first before accessing the main data page. 
  - Validation features
    - Username checked for availability.
    - Confirm password field is added.
    - Phone number field to accept only 10 digit numbers.
    - Birth Date field for Date of Birth of user and only accepts this pattern (YYYY-MM-DD).
  - The user data along with time of registration is stored in a separate table.
  - Password is encrypted using function in PHP.
  ```php
  function encrypt($str){
        $ciphering = "BF-CBC";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '808fc44d';
        $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);
        $encryption = openssl_encrypt($str, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
  ```
  - While logging in, he/she is redirected to relevant page based on the type of user(*Admin or User*).
  - User features
    - Search/Crawl amazon data for title, image and price of products.
    - Send a feedback message.
  - Admin features
    - Create new user.
    - Delete an existing user.
    - Show the users.
    - Display the messages.
    - Download user data.
    - All other features of a user.
    
- [x] __Website need to be fully functional (links should work) __
  - All the redirections are taken care.
  
- [x] __Insertion, deletion, updation, search, different types of file upload/download operations,
notifications and alerts based on the application. These operations should
implement the Ajax, JQuery and JSON features.__
  - Ajax
    - Ajax is used to validate if a username if he is already registered without reloading the page.
    - Result is fetched and displayed when the textfield is changed.
    ```php
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").style.color = "red";
            document.getElementById("txtHint").innerHTML =
            this.responseText;
        }
    };
    xmlhttp.open("GET", "getUsername.php?username=" + str, true);
    xmlhttp.send();
    ```
     
    
  - jQuery
    - Used in the welcome page for animation purpose.
    - When hovered on heading it's color is changed and zoomed.
    - And when clicked on that div, `Login`, `Register` and `Forgot Password?` buttons will be displayed.
    ```js
    $("h1").mouseenter(function () {
        $(this).animate({ fontSize: '4em' }, 400);
        $(this).css("color", "#c05555");
    })
    $("h1").mouseleave(function () {
        $(this).animate({ fontSize: '3em' }, 200);
        $(this).css("color", "black");
    })
    $("#head").click(function () {
        $("#div1").fadeIn();
        $("#div2").fadeIn(1000);
        $("#div3").fadeIn(2000);
    });
    ```
    
    - It is also used to validate __phonenumber__ and __birth date__.
    
    ``` js
    $(document).ready(function () {
        $('#birth-date').mask('0000-00-00');
        $('#phone-number').mask('0000-000-000');
    })
    ```

    - Used in admin page to toggle side bar.
    ```js
    $("#menu-toggle").click(function(e){
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    })
    ```
    
  - JSON
    - All the user data is written into a file in `json` format.
    
  - File Download
    - The json file can be downloaded by admin
    ```php
    
    $file = ("C:\\xampp\\htdocs\\task1\\file.json");

    $filetype=filetype($file);

    $filename="file.json";

    header ("Content-Type: ".$filetype);

    header ("Content-Length: ".filesize($file));

    header ("Content-Disposition: attachment; filename=".$filename);

    readfile($file);
    ```
