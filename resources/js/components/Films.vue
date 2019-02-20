<template>
  <main role="main">
    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Films Listing App</h1>
        <p
          class="lead text-muted"
        >A film listing application that uses Laravel API Resources as backend and VueJs as front end. This app utilizes all freatures of Vuejs like, Vue Router, Vuex and Axios to fetch API data.
          <br>It's a full CRUD application that also features Authentication using Passport.
        </p>
      </div>
    </section>
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-4" v-for="film in films" :key="film.id">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" :src="'/images/'+film.film_photo" v-if="film.film_photo">
              <img src="https://via.placeholder.com/200" alt="Placeholder" v-else>
              <div class="card-body">
                <h4>{{ film.name | truncate(25, '...') }}</h4>
                <p class="card-text">{{film.description | truncate(100, '...')}}.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <router-link
                      :to="{name: 'singleFilm', params: {slug: film.slug} }"
                      tag="button"
                      class="btn btn-sm btn-outline-secondary"
                    >View</router-link>
                    <router-link
                      :to="{name: 'editFilm', params: {slug: film.slug} }"
                      tag="button"
                      class="btn btn-sm btn-outline-secondary"
                    >Edit</router-link>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-secondary"
                      @click="deleteFilm(film.id)"
                    >Delete</button>
                  </div>
                  <small class="text-muted comments">{{film.comments_count}} Comments</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="...">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="[{disabled: !pagination.prev_page_url}]">
                  <span @click="fetchFilms(pagination.prev_page_url)" class="page-link">Previous</span>
                </li>
                <li
                  class="page-item"
                  :class="{active: pagination.current_page == page}"
                  v-for="page in pages"
                  :key="page"
                >
                  <span
                    class="page-link"
                    @click="fetchFilms(fetch_url + 'api/film?page='+page)"
                  >{{page}}</span>
                </li>
                <li class="page-item" :class="[{disabled: !pagination.next_page_url}]">
                  <span @click="fetchFilms(pagination.next_page_url)" class="page-link">Next</span>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      films: [],
      pagination: {},
      fetch_url: process.env.MIX_APP_URL
    };
  },
  created() {
    this.fetchFilms();
  },
  methods: {
    fetchFilms(page_url) {
      let vm = this;
      page_url = page_url || this.fetch_url + "api/film";
      api
        .call("get", page_url)
        //.then(res => res.json())
        .then(res => {
          //console.log(res);
          this.films = res.data.data;
          vm.makePginate(res.data.meta, res.data.links);
        });
    },

    makePginate(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },

    deleteFilm(film_id) {
      if (confirm("Are you sure")) {
        api
          .call("delete", this.fetch_url + "api/film/" + film_id)
          .then(res => {
            //console.log(res);
            this.films.splice(this.films.indexOf(film_id), 1);
            alert(res.data.data.name + "deleted successfully");
            this.fetchFilms();
          })
          .catch(err => {
            console.log(err);
          });
      }
    }
  },
  computed: {
    pages() {
      let vm = this;
      let pages = [];
      for (let i = 1; i <= vm.pagination.last_page; i++) {
        pages.push(i);
      }
      return pages;
    }
  },
  filters: {
    truncate: (text, length, suffix) => {
      if (!text) return "";
      text = text.toString();
      return text.substring(0, length) + suffix;
    }
  }
};
</script>

<style scoped>
.page-item.active .page-link {
  background: #55595c;
  border-color: #212529;
}
.page-link {
  color: #55595c;
}
.comments {
  text-decoration: underline;
}
</style>