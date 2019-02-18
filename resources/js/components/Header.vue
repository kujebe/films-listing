<template>
  <div>
    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <router-link to="/" exact tag="a" class="navbar-brand d-flex align-items-center">
            <strong>Films</strong>
          </router-link>
          <ul class="nav justify-content-end">
            <li class="nav-item">
              <router-link class="nav-link" activeClass="active" tag="a" to="/new-film">New Film</router-link>
            </li>
            <li class="nav-item" v-if="authenticated && user">
              <p>Hello, {{ user.name }}</p>
              <router-link class="nav-link" activeClass="active" tag="a" to="/logout">logout</router-link>
            </li>
            <li class="nav-item" v-else>
              <router-link class="nav-link" activeClass="active" tag="a" to="/login">Login</router-link>
            </li>
          </ul>
        </div>
      </div>
    </header>
  </div>
</template>