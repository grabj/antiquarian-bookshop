
<nav class="navbar navbar-expand-md navbar-dark bg-dark pb-2 bg-gradient">
    <div class="container-fluid">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-0 mb-lg-0 p-1">
                <li class="nav-item m-auto">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item m-auto">
                    <a class="nav-link" href="./index.php#products">Products</a>
                </li>
                
                <li class="nav-item m-auto">
                <?php 
                if(!isset($_SESSION['user_id']))
                {
                    echo"
                    <a class='nav-link disabled' href=''>
                        Cart <i class='fa-solid fa-cart-shopping'></i>
                        <sup>0</sup></a>";
                }
                else{
                    echo"
                    <a class='nav-link' href='./cart.php'>
                        Cart <i class='fa-solid fa-cart-shopping'></i>
                        <sup class='text-info'>";
                            print count_items() .
                        "</sup></a>";
                }
                ?>
                </li>
            </ul>       
            <?php
                mainNavbar();


            ?>
        </div>
    </div>
 </nav>