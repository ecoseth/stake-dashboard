<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"
          ><i class="fas fa-bars"></i
        ></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item d-none" id="loader">
        <div class="loader">
          <main class="main">
            <svg class="ip" viewBox="0 0 256 128" width="50px" height="35px" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stop-color="#5ebd3e" />
                  <stop offset="33%" stop-color="#ffb900" />
                  <stop offset="67%" stop-color="#f78200" />
                  <stop offset="100%" stop-color="#e23838" />
                </linearGradient>
                <linearGradient id="grad2" x1="1" y1="0" x2="0" y2="0">
                  <stop offset="0%" stop-color="#e23838" />
                  <stop offset="33%" stop-color="#973999" />
                  <stop offset="67%" stop-color="#009cdf" />
                  <stop offset="100%" stop-color="#5ebd3e" />
                </linearGradient>
              </defs>
              <g fill="none" stroke-linecap="round" stroke-width="16">
                <g class="ip__track" stroke="#ddd">
                  <path d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"/>
                  <path d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"/>
                </g>
                <g stroke-dasharray="180 656">
                  <path class="ip__worm1" stroke="url(#grad1)" stroke-dashoffset="0" d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"/>
                  <path class="ip__worm2" stroke="url(#grad2)" stroke-dashoffset="358" d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"/>
                </g>
              </g>
            </svg>
          </main>
        </div>
      </li>

      <!-- Navbar Search -->
      <li class="nav-item">
        <a
          class="nav-link"
          data-widget="navbar-search"
          href="#"
          role="button"
        >
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input
                class="form-control form-control-navbar"
                type="text"
                placeholder="Search"
                aria-label="Search"
              />
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button
                  class="btn btn-navbar"
                  type="button"
                  data-widget="navbar-search"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Full Screen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>