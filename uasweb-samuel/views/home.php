<?php
if (isset($_SESSION['display_name'])) {
  $logged_in = true;
  $id = $_SESSION['id'];
  $display_name = $_SESSION['display_name'];
  $username = $_SESSION['username'];
  $role = $_SESSION['role'] == 'admin';
} else {
  $logged_in = false;
  $role = false;
}

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$fullUrl = "$protocol://$host$uri";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEARNING MEDIA MPTI</title>
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/chatting.css">


</head>
<script src="/js/vue.global.js"></script>
<!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->


<style>
  .hidden {
    display: none;
  }

  .rotate-90 {
    transform: rotate(90deg);
    transition: transform 0.3s;
  }

  .rotate-0 {
    transform: rotate(0deg);
    transition: transform 0.3s;
  }

  .alert {
    position: absolute;
    top: 10px;
    right: 10px;
    transform: translateY(-100%);
    animation: slideIn 0.3s ease forwards;
    display: none;
  }

  .alert.show {
    display: block;
  }

  @keyframes slideIn {
    from {
      transform: translateY(-100%);
    }

    to {
      transform: translateY(0);
    }
  }

  /* .line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
} */
</style>

<body>
  <div id="app">
    <div id="alertError"
      class="alert p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <span class="font-medium">Gagal!</span> Data Buku Baru Gagal Ditambahkan.
    </div>
    <header class="w-full">
      <div class="w-full h-20 py-4 flex justify-center items-center border-b-2 border-b-gray-900">
        <h1 class="text-3xl font-bold">SELAMAT DATANG DI LEARNING MEDIA MPTI </h1>
      </div>
      <div class="w-full flex justify-end items-center bg-sky-950 p-5">
        <nav>
          <?php if ($logged_in): ?>
            <div id="nav-button"
              class="flex flex-row justify-center items-center gap-3 bg-indigo-500 rounded-xl py-3 px-6 cursor-pointer">
              <p class="text-2xl text-white font-bold">Selamat Datang, <span class="italic"><?= $display_name ?></span>
              </p>
              <div class="relative flex justify-center items-center">
                <button id="dropdownButton" class="focus:outline-none bg-indigo-800 rounded-xl p-2">
                  <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 9-7 7-7-7" />
                  </svg>
                </button>
                <div id="dropdownMenu"
                  class="hidden absolute right-0 top-8 mt-2 w-48 bg-white rounded-md drop-shadow-lg py-2 z-50">
                  <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Keluar</a>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div>
              <a href="/login" class="py-3 px-6 font-bold text-white bg-indigo-500 rounded-xl">Login</a>
            </div>
          <?php endif; ?>
        </nav>
      </div>
    </header>
    <main class="container mx-auto">
      <div class="h-28 flex justify-between items-center w-full">
        <form class="w-[300px]">
          <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Title,
            Author, Sypnosis and Publisher date</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none ">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
              </svg>
            </div>
            <input @input="e => searchBook(1, e.target.value)" type="search" id="default-search"
              class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Search Mockups, Logos..." required />

          </div>
        </form>
        <div>
          <?php if ($role): ?>
            <button id="add-book" type="button"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 flex flex-row justify-center items-center gap-2">
              <p>Add</p>
              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
            </button>
          <?php endif; ?>
        </div>
      </div>
      <div id="cards" class="flex justify-center items-center flex-wrap gap-6">
        <div v-for="search in searchs">
          <div
            class="w-[300px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-center items-center h-[190px] overflow-hidden">
              <img v-if="search.image_url.length > 0" class="rounded-t-lg" :src="'/img/'+search.image_url"
                :alt="search.title" />
              <img v-else class="rounded-t-lg" src="/img/question-mark.png" :alt="search.title" />

            </div>
            <div class="p-5">
              <a href="#">
                <h5
                  class="h-[40px] w-full mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white overflow-hidden text-ellipsis whitespace-nowrap">
                  {{ search.title }}</h5>
              </a>
              <p class="w-[258px] line-clamp-3 mb-3 font-normal text-gray-700 dark:text-gray-400">{{
                extractTextFromHTML(search.synopsis) }}
              </p>
              <a :href="'/book-detail?detail=' + search.id"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Materi Pembelajaran
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>

        </div>


    </main>
    <div v-if="pagination.current_page != null" class="mt-10 flex flex-row justify-center items-center">
      <div class="pt-4 px-16 rounded-2xl border-2 border-indigo-500">
        <button @click="searchBook(pagination.prev_page)" type="button" v-if="pagination.prev_page != null"
          class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">{{
          pagination.prev_page }}</button>
        <button @click="searchBook(pagination.current_page)" v-if="pagination.current_page != null" type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{pagination.current_page}}</button>
      </div>
      <button @click="searchBook(pagination.next_page)" type="button" v-if="pagination.next_page != null"
        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">{{pagination.next_page}}</button>
    </div>
    <div v-else>
      <h1 class="text-4xl text-center w-full font-bold text-indigo-500">Tidak Ada Informasi Materi yang bisa diakses!
      </h1>
    </div>


    <?php if ($logged_in): ?>
      <?php if ($role == 'admin'): ?>
        <div id="floating-button" class="floating-button" v-on:click="goChat">
          <img src="/img/messenger.png" alt="Chat" />
        </div>
      <?php else: ?>
        <div id="floating-button" class="floating-button" v-on:click="activeChat">
          <img src="/img/messenger.png" alt="Chat" />
        </div>

        <!-- Jendela Chat -->
        <div id="chat-window" class="chat-window" :class="{'hidden' : chatOpen}">
          <div class="chat-header">
            <h3>MPTI HELPER</h3>
            <button id="close-chat" class="close-btn" v-on:click="activeChat">X</button>
          </div>
          <div class="chat-body">
            <?php if ($logged_in): ?>
              <div v-for="message in messages" v-if="messages.length > 0" class="chat-wrap">
                <div class="chat-bubble sender" v-if="message.sender_id == '<?= $id ?>'">
                  <p>{{ message.message }}</p>
                </div>
                <div class="chat-bubble receiver" v-else>
                  <p>{{ message.message }}</p>
                </div>
              </div>
              <div v-else>
                <div>Belum ada pesan</div>
              </div>
            <?php else: ?>
              <div>Maaf Kamu Harus Login Terlebih dahulu!</div>
            <?php endif; ?>

          </div>
          <?php if ($logged_in): ?>
            <div class="chat-footer">
              <input type="text" name="message" v-model="inputChat" placeholder="Tulis Pesan..." />
              <button v-on:click="sendMessage">Send</button>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <!--Progress-->
  <div id="project-progress" class="progress-window" :class="{'hidden': !progressOpen}">
  <div class="progress-header">
    <h3>Dashboard Kemajuan Proyek</h3>
    <button id="close-progress" class="close-btn" v-on:click="toggleProgress">X</button>
  </div>

  <div class="progress-body">
    <?php if ($logged_in): ?>
      <div v-if="tasks.length > 0">
        <div class="task" v-for="task in tasks" :key="task.id">
          <h4>{{ task.name }}</h4>
          <p>Status: {{ task.status }}</p>
          <p>Progress: {{ task.progress }}%</p>
        </div>
      </div>
      <div v-else>
        <p>Belum ada tugas yang tersedia.</p>
      </div>
    <?php else: ?>
      <p>Maaf, Anda harus login terlebih dahulu!</p>
    <?php endif; ?>
  </div>

  <?php if ($logged_in): ?>
    <div class="progress-footer">
      <input type="text" v-model="newTaskName" placeholder="Nama Tugas Baru" />
      <button v-on:click="addTask">Tambahkan Tugas</button>
    </div>
  <?php endif; ?>
</div>

<script>
new Vue({
  el: '#project-progress',
  data: {
    progressOpen: true,
    tasks: [
      // Data tugas bisa diambil dari database atau diisi secara dinamis
      { id: 1, name: 'Analisis Kebutuhan', status: 'Dalam Progres', progress: 50 },
      { id: 2, name: 'Desain UI', status: 'Selesai', progress: 100 },
    ],
    newTaskName: '',
  },
  methods: {
    toggleProgress() {
      this.progressOpen = !this.progressOpen;
    },
    addTask() {
      if (this.newTaskName) {
        this.tasks.push({ id: this.tasks.length + 1, name: this.newTaskName, status: 'Belum Dimulai', progress: 0 });
        this.newTaskName = '';
      }
    }
  }
});
</script>

<style>
/* Styling untuk komponen kemajuan proyek */
.progress-window {
  width: 300px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.progress-header {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  text-align: center;
}
.progress-body {
  padding: 10px;
}
.progress-footer {
  padding: 10px;
  display: flex;
  justify-content: space-between;
}
.close-btn {
  background: none;
  border: none;
  color: white;
  font-size: 16px;
  cursor: pointer;
}
</style>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let navButton = document.getElementById('nav-button');
      var dropdownButton = document.getElementById('dropdownButton');
      var dropdownMenu = document.getElementById('dropdownMenu');

      navButton.addEventListener('click', function () {
        dropdownMenu.classList.toggle('hidden');
      });

      window.addEventListener('click', function (event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.add('hidden');
        }
      });

      let addBook = document.getElementById('add-book');
      addBook.addEventListener('click', function () {
        window.location.href = '/add-materi';
      });
    });
  </script>
  <script>
    const {
      createApp,
      ref,
      reactive,
      onMounted,
      onBeforeUnmount
    } = Vue

    createApp({
      setup() {
        const searchs = ref([]);
        const pagination = ref({});
        const inputChat = ref('');
        const chatOpen = ref(true);
        const messages = ref([]);

        async function getMessage() {
          await fetch(`/api/message/<?= isset($id) ? $id : null ?>`, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json'
            }
          })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                messages.value = data.data;
              } else {
                messages.value = [];
              }
            });
        }

        <?php if ($logged_in): ?>
          onMounted(() => {
            getMessage();
          });
        <?php endif; ?>
        onMounted(() => {
          searchBook()
        });

        async function searchBook(page = 1, search = '') {
          fetch(`/api/books?page=${page}&name=${search}`, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json'
            }
          })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                console.log(page, search);
                console.log(data);
                searchs.value = data.data;
                pagination.value = data.pagination;
              } else {
                showAlert();
                searchs.value = [];
                pagination.value = {
                  current_page: null,
                  next_page: null,
                  prev_page: null
                };
              }
            });
        };

        function showAlert() {
          const alertElement = document.getElementById('alertError');
          alertElement.classList.add('show');
          setTimeout(function () {
            alertElement.classList.remove('show');
          }, 3000);
        }

        function extractTextFromHTML(htmlString) {
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = htmlString;
          const firstParagraph = tempDiv.querySelector('p');
          if (firstParagraph) {
            return firstParagraph.innerText;
          }
          for (let i = 2; i <= 6; i++) {
            const heading = tempDiv.querySelector(`h${i}`);
            if (heading) {
              return heading.innerText;
            }
          }
          return 'Tidak ada detail';
        }


        function sendMessage() {
          const formData = new FormData();
          formData.append('message', inputChat.value);
          formData.append('sender_id', "<?= isset($id) ? $id : null ?>");
          formData.append('receiver_id', "admin");

          fetch('/api/message', {
            method: 'POST', // Metode POST
            body: formData // Mengirimkan FormData sebagai body
          })
            .then(response => response.text()) // Mengambil response dalam bentuk teks
            .then(data => {
              if (data.includes('status=success')) {
                inputChat.value = '';
                getMessage();
              } else {
                alert('Failed to send message');
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });

        }

        function activeChat() {
          chatOpen.value = !chatOpen.value;
        }

        function goChat() {
          window.location.href = '/chat';
        }


        return {
          searchs,
          pagination,
          searchBook,
          extractTextFromHTML,
          inputChat,
          chatOpen,
          activeChat,
          sendMessage,
          messages,
          goChat
        }
      }
    }).mount('#app')
  </script>
</body>

</html>