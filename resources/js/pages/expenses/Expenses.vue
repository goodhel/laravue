<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'expenses.create' }" class="btn btn-primary btn-sm ">Tambah</router-link>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
              
              	<!-- TABLE INI AKAN MENAMPILKAN DATA EXPENSES -->
                <b-table striped hover bordered :items="expenses.data" :fields="fields" show-empty>
                    <template v-slot:cell(status)="row">
                        <span class="badge bg-success" v-if="row.item.status == 1">Diterima</span>
                        <span class="badge bg-warning" v-else-if="row.item.status == 0">Diproses</span>
                        <span class="badge bg-secondary" v-else>Ditolak</span>
                    </template>
                    <template v-slot:cell(user)="row">
                        {{ row.item.user.name }}
                    </template>
                    <template v-slot:cell(reason)="row">
                        {{ row.item.reason == '' ? '-':row.item.reason }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'expenses.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm" v-if="row.item.status == 0"><i class="fas fa-edit"></i></router-link>
                        <router-link :to="{ name: 'expenses.view', params: {id: row.item.id} }" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteExpenses(row.item.id)" v-if="row.item.status == 0"><i class="fas fa-trash"></i></button>
                    </template>
                </b-table>
                <!-- TABLE INI AKAN MENAMPILKAN DATA EXPENSES -->
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                  	<!-- BAGIAN INI AKAN MENAMPILKAN INFORMASI DATA DAN PAGINATION -->
                    <div class="col-md-6">
                        <p v-if="expenses.data"><i class="fa fa-bars"></i> {{ expenses.data.length }} item dari {{ expenses.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="expenses.meta.total"
                                :per-page="expenses.meta.per_page"
                                aria-controls="expenses"
                                v-if="expenses.data && expenses.data.length > 0"
                                ></b-pagination>
                        </ul>
                    </div>
                    <!-- BAGIAN INI AKAN MENAMPILKAN INFORMASI DATA DAN PAGINATION -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataExpenses',
    created() {
        this.getExpenses() //KETIKA HALAMAN DI-LOAD MAKA FUNGSI INI AKAN DIJALANKAN
    },
    data() {
        return {
            //UNTUK FIELD TABLE DIATAS YANG AKAN DITAMPILKAN
            fields: [
                { key: 'description', label: 'Permintaan' },
                { key: 'price', label: 'Biaya' },
                { key: 'note', label: 'Catatan' },
                { key: 'user', label: 'Kurir/Admin' },
                { key: 'status', label: 'Status' },
                { key: 'reason', label: 'Alasan' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: '' //VARIABLE UNTUK SEARCH
        }
    },
    computed: {
        ...mapState('expenses', {
            expenses: state => state.expenses //AMBIL STATE DARI MODULE EXPENSES YANG AKAN DIBUAT KEMUDIAN
        }),
        //AMBIL DAN MODIFIKASI STATE PAGE JIKA TERJADI PERUBAHAN
        page: {
            get() {
                return this.$store.state.expenses.page
            },
            set(val) {
                this.$store.commit('expenses/SET_PAGE', val)
            }
        }
    },
    watch: {
        //KETIKA TERJADI PERUBAHAN VALUE STATE PAGE 
        page() {
            this.getExpenses() //MAKA JALANKAN FUNGSI INI
        },
        //KETIKA TERJADI PERUBAHAN VALUE VARIABLE SEARCH 
        search() {
            this.getExpenses(this.search) //MAKA JALANKAN FUNGSI INI DGN MENGIRIMKAN VALUE DARI SEARCH
        }
    },
    methods: {
        ...mapActions('expenses', ['getExpenses', 'removeExpenses']), //DEFINISIKAN ACTIONS DARI MODULE EXPENSES
        //FUNGSI INI SAMA DENGAN MODULE SEBELUMNYA UNTUK MENAMPILKAN ALERT KETIKA MENGHAPUS DATA
        deleteExpenses(id) {
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    //JIKA DISETUJUI MAKA FUNGSI INI DIJALANKAN
                    this.removeExpenses(id)
                }
            })
        }
    }
}
</script>
