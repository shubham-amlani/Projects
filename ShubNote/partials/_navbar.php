<?php
function checkPage($str){
    if(str_contains($_SERVER['PHP_SELF'], $str)){
        return true;
    }
    else{
        return false;
    }
}

// Navbar will be displayed differently according to different pages
echo '
<nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-sm-top ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">shubNote</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a
            class="nav-link '.(checkPage('home.php')?'active':'').'"
            aria-current="page"
            href="home.php"
            >Home</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link '.(checkPage('explore.php')?'active':'').'" href="explore.php">Explore</a>
        </li>
        <li class="nav-item">
          <a class="nav-link '.(checkPage('about.php')?'active':'').'" href="about.php">About</a>
        </li>
      </ul>';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<button class="btn btn-outline-info"><a href="myaccount.php" class="nav-link">My account</a></button>
        <form class="d-flex mx-0 mx-md-4 my-4 my-md-0" role="search" action="search.php" method="get">
        <input
          class="form-control me-2"
          type="search"
          placeholder="Search"
          aria-label="Search"
          name="search"
        />
        <button class="btn btn-success" type="submit">Search</button>
      </form>
      <button class="btn btn-outline-success">
        <a href="partials/_logout.php" class="nav-link">Logout</a>
      </button>';
      }
      else{
        echo '<div class="buttons mx-0 d-flex gap-2 mt-md-0 mx-md-2 mt-2">
        <button class="btn btn-outline-success">
          <a href="login.php" class="nav-link">Login</a>
        </button>
        <button class="btn btn-outline-primary">
          <a href="signup.php" class="nav-link">Signup</a>
        </button>
      </div>';
      }
echo '</div>
  </div>
</nav>
'; ?>