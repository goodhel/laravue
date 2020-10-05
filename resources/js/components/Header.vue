<template>
        <!-- Navbar -->
        <nav class=" main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <div class="navbar-header">
                    <router-link to="/" class="navbar-brand">
                        <!-- <img src="{{ asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                            style="opacity: .8"> -->
                        <span class="brand-text font-w700">AdminLTE 3</span>
                    </router-link>
                </div>
                
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <!-- <li class="active"><router-link to="/">Home <span class="sr-only">(current)</span></router-link></li> -->
                        <li class="nav-item">
                            <router-link class="nav-link" to="/">Home <span class="sr-only">(current)</span></router-link>
                        </li>
                        <li class="nav-item" v-if="$can('read outlets')">
                            <router-link class="nav-link" :to="{ name: 'outlets.data' }">Outlets</router-link>
                        </li>
                        <li class="nav-item" v-if="$can('read couriers')">
                            <router-link class="nav-link" :to="{ name: 'couriers.data' }">Courier</router-link>
                        </li>
                        <li class="nav-item" v-if="$can('read products')">
                            <router-link class="nav-link" :to="{ name: 'products.data' }">Products</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'expenses.data' }">Expenses</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'customers.data' }">Customers</router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Transactions <span class="caret"></span></a>
                            <ul class="dropdown-menu border-0 shadow" role="menu">
                                <li><router-link class="dropdown-item" :to="{ name: 'transactions.list'}">List</router-link></li>
                                <li><router-link class="dropdown-item" :to="{ name: 'transactions.add' }">Add New</router-link></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown" v-if="authenticated.role == 0">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Settings <span class="caret"></span></a>
                            <ul class="dropdown-menu border-0 shadow" role="menu">
                                <li><router-link class="dropdown-item" :to="{name: 'role.permission'}">Role Permission</router-link></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li><a href="#" class="dropdown-item">Some action </a></li>
                                <li><a href="#" class="dropdown-item">Some other action</a></li>

                                <li class="dropdown-divider"></li>

                                 Level two dropdown
                                <li class="dropdown-submenu dropdown-hover">
                                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                    </li>

                                     Level three dropdown
                                    <li class="dropdown-submenu">
                                        <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                        <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        </ul>
                                    </li>
                                    End Level three 

                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                    </ul>
                                </li>
                                 End Level two 
                            </ul>
                        </li> -->
                    </ul>

                    <!-- SEARCH FORM -->
                    <!-- <form class="form-inline ml-0 ml-md-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            </div>
                        </div>
                    </form> -->
                </div>
                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <!-- <li class="nav-item">
                        <a href="javascript:void(0)" @click="logout" class="btn btn-default btn-sm nav-link">Sign out</a>
                    </li> -->
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a  href="#" class="nav-link" data-toggle="dropdown">
                            <i class="fas fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">{{ notifications.length }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div v-if="notifications.length > 0">
                                <!-- KITA MELAKUKAN LOOPING TERHADAP DATA NOTIFIKASI YANG DISIMPAN KE DALAM STATE NOTIFICATIONS -->
                                <div v-for="(row, index) in notifications" :key="index">
                                    <a href="javascript:void(0)" @click="readNotif(row)" class="dropdown-item">
                                    <!-- Message Start -->
                                    <div class="media">
                                        <img src="https://via.placeholder.com/160" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{ row.data.sender_name }}
                                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">{{ row.data.expenses.description.substr(0, 30) }}</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ row.created_at | formatDate }}</p>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                    </a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown" >
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">{{ notifications.length }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">{{ notifications.length }} Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <!-- User Menu -->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://via.placeholder.com/160" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{ authenticated.name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="https://via.placeholder.com/160" class="img-circle elevation-2" alt="User Image">

                            <p>
                            {{ authenticated.name }}
                            <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                            <div class="col-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a href="javascript:void(0)" @click="logout" class="btn btn-default btn-flat float-right">Sign out</a>
                        </li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                        class="fas fa-th-large"></i></a>
                    </li> -->
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->
</template>

<script>
import { mapState, mapActions } from 'vuex'
import moment from 'moment'

export default {
    computed: {
        ...mapState('user', {
            authenticated: state => state.authenticated //ME-LOAD STATE AUTHENTICATED
        }),
        //CUKUP TAMBAHKAN BAGIAN INI
        ...mapState('notification', {
            notifications: state => state.notifications //MENGAMBIL STATE NOTIFICATIONS
        })
    },
    //TAMBAHKAN JUGA BAGIAN INI
    filters: {
        //UNTUK MENGUBAH FORMAT TANGGAL MENJADI TIME AGO
        formatDate(val) {
            return moment(new Date(val)).fromNow()
        }
    },
    methods: {
        ...mapActions('notification', ['readNotification']), //DEFINISIKAN FUNGSI UNTUK READ NOTIF
        
        //KETIKA NOTIFIKASI DI KLIK MAKA AKAN MENJALANKAN FUNGSI INI
        readNotif(row) {
            //MENGIRIMKAN REQUEST KE SERVER UNTUK MENANDAI BAHWA NOTIFIKASI TELAH DI BACA
            //KEMUDIAN SELANJUTNYA KITA REDIRECT KE HALAMAN VIEW EXPENSES
            this.readNotification({ id: row.id}).then(() => this.$router.push({ name: 'expenses.view', params: {id: row.data.expenses.id} }))
        },
        //KETIKA TOMBOL LOGOUT DITEKAN, FUNGSI INI DIJALANKAN
        logout() {
            return new Promise((resolve, reject) => {
                localStorage.removeItem('token') //MENGHAPUS TOKEN DARI LOCALSTORAGE
                resolve()
            }).then(() => {
                //MEMPERBAHARUI STATE TOKEN
                this.$store.state.token = localStorage.getItem('token')
                this.$router.push('/login') //REDIRECT KE PAGE LOGIN
            })
        }
    }
}
</script>