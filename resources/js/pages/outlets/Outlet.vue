<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'outlets.add' }" class="btn btn-primary btn-sm">Tambah</router-link>
                <!-- <h3 class="card-title">Responsive Hover Table</h3> -->
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <!-- <div class="pull-right">
                    <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                </div> -->
            </div>
            <div class="card-body table-responsive p-0">
                <b-table striped hover bordered :items="outlets.data" :fields="fields" show-empty>
                    <template v-slot:cell(status)="row">
                        <span class="badge bg-success" v-if="row.item.status == 1">Active</span>
                        <span class="badge bg-primary" v-else>Inactive</span>
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'outlets.edit', params: {id: row.item.code} }" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteOutlet(row.item.id)"><i class="fas fa-trash"></i></button>
                    </template>
                </b-table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <p v-if="outlets.data"><i class="fa fa-bars"></i> {{ outlets.data.length }} item dari {{ outlets.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="outlets.meta.total"
                                :per-page="outlets.meta.per_page"
                                aria-controls="outlets"
                                v-if="outlets.data && outlets.data.length > 0"
                            ></b-pagination>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataOutlet',
    created() {
        //SEBELUM COMPONENT DI-LOAD, REQUEST DATA DARI SERVER
        this.getOutlets()
    },
    data() {
        return {
            //FIELD UNTUK B-TABLE, PASTIKAN KEY NYA SESUAI DENGAN FIELD DATABASE
            //AGAR OTOMATIS DI-RENDER
            fields: [
                { key: 'code', label: 'Kode Outlet' },
                { key: 'name', label: 'Nama Outlet' },
                { key: 'address', label: 'Alamat' },
                { key: 'phone', label: 'Telp' },
                { key: 'status', label: 'Status' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        //MENGAMBIL DATA OUTLETS DARI STATE OUTLETS
        ...mapState('outlet', {
            outlets: state => state.outlets
        }),
        page: {
            get() {
                //MENGAMBIL VALUE PAGE DARI VUEX MODULE outlet
                return this.$store.state.outlet.page
            },
            set(val) {
                //APABILA TERJADI PERUBAHAN VALUE DARI PAGE, MAKA STATE PAGE
                //DI VUEX JUGA AKAN DIUBAH
                this.$store.commit('outlet/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            //APABILA VALUE DARI PAGE BERUBAH, MAKA AKAN MEMINTA DATA DARI SERVER
            this.getOutlets()
        },
        search() {
            //APABILA VALUE DARI SEARCH BERUBAH MAKA AKAN MEMINTA DATA
            //SESUAI DENGAN DATA YANG SEDANG DICARI
            this.getOutlets(this.search)
        }
    },
    methods: {
        //MENGAMBIL FUNGSI DARI VUEX MODULE outlet
        ...mapActions('outlet', ['getOutlets', 'removeOutlet']),
        //KETIKA TOMBOL HAPUS DICLICK, MAKA AKAN MENJALANKAN METHOD INI
        deleteOutlet(id) {
            //AKAN MENAMPILKAN JENDELA KONFIRMASI
            this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            }).then((result) => {
                //JIKA DISETUJUI
                if (result.value) {
                    //MAKA FUNGSI removeOutlet AKAN DIJALANKAN
                    this.removeOutlet(id)
                }
            })
        }
    }
}
</script>