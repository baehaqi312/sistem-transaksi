<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
  <div>
    <ul class="nav-main">
      <li class="nav-main-item">
        <Link class="nav-main-link active" :href="route('dashboard')">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Dashboard</span>
        </Link>
      </li>
      <li class="nav-main-item">
        <Link class="nav-main-link" :href="route('test')">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Dashboard</span>
        </Link>
      </li>
      <li class="nav-main-heading">User Interface</li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" href="#">
          <i class="nav-main-link-icon si si-energy"></i>
          <span class="nav-main-link-name">Blocks</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_blocks_styles.html">
              <span class="nav-main-link-name">Styles</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-main-item">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
          <i class="nav-main-link-icon si si-trophy"></i>
          <span class="nav-main-link-name">Widgets</span>
        </a>
        <ul class="nav-main-submenu">
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_tiles.html">
              <span class="nav-main-link-name">Tiles</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_users.html">
              <span class="nav-main-link-name">Users</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_stats.html">
              <span class="nav-main-link-name">Statistics</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link" href="be_widgets_blog.html">
              <span class="nav-main-link-name">Blog</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>
