// Vendor CSS Files
import './assets/vendor/bootstrap/css/bootstrap.min.css'
import './assets/vendor/bootstrap-icons/bootstrap-icons.css'
import './assets/vendor/boxicons/css/boxicons.min.css'
import './assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css'
import './assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css'
import './assets/vendor/datatables-buttons/css/buttons.bootstrap4.min.css'
import './assets/vendor/quill/quill.snow.css'
import './assets/vendor/quill/quill.bubble.css'
import './assets/vendor/remixicon/remixicon.css'
import './assets/vendor/simple-datatables/style.css'
// Template Main CSS File
import './assets/css/style.css'


// Vendor JS Files
import './assets/vendor/jquery/jquery.min.js'
import './assets/vendor/datatables/jquery.dataTables.min.js'
import './assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js'
import './assets/vendor/datatables-responsive/js/dataTables.responsive.min.js'
import './assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js'
import './assets/vendor/datatables-buttons/js/dataTables.buttons.min.js'
import './assets/vendor/datatables-buttons/js/buttons.bootstrap4.min.js'
import './assets/vendor/jszip/jszip.min.js'
import './assets/vendor/pdfmake/pdfmake.min.js'

import './assets/vendor/datatables-buttons/js/buttons.html5.min.js'
import './assets/vendor/datatables-buttons/js/buttons.print.min.js'
import './assets/vendor/datatables-buttons/js/buttons.colVis.min.js'
import './assets/vendor/apexcharts/apexcharts.min.js'
import './assets/vendor/bootstrap/js/bootstrap.bundle.min.js'
import './assets/vendor/chart.js/chart.umd.js'
import './assets/vendor/echarts/echarts.min.js'
import './assets/vendor/quill/quill.min.js'
import './assets/vendor/simple-datatables/simple-datatables.js'
import './assets/vendor/tinymce/tinymce.min.js'
import './assets/vendor/php-email-form/validate.js'


// Template Main JS File
import './assets/js/main.js'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

createApp(App)

.use(router)

.mount('#app')
