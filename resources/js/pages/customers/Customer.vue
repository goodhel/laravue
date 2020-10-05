<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'customers.add' }" class="btn btn-primary btn-sm">Tambah</router-link>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
              
              	<!-- TABLE UNTUK MENAMPILKAN LIST CUSTOMER -->
                <b-table striped hover bordered :items="customers.data" :fields="fields" show-empty>
                    <template slot="deposit" slot-scope="row">
                        Rp {{ row.item.deposit }}
                    </template>
                  	
                  	<!-- NAMA KURIR AKAN DITAMPILKAN JIKA ADA -->
                    <template slot="courier_id" slot-scope="row">
                        {{ row.item.courier ? row.item.courier.name:'-' }}
                    </template>
                    <template slot="actions" slot-scope="row">
                        <router-link :to="{ name: 'customers.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteCustomer(row.item.id)"><i class="fa fa-trash"></i></button>
                    </template>
                </b-table>
              	<!-- TABLE UNTUK MENAMPILKAN LIST CUSTOMER -->

            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <p v-if="customers.data"><i class="fa fa-bars"></i> {{ customers.data.length }} item dari {{ customers.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="customers.meta.total"
                                :per-page="customers.meta.per_page"
                                aria-controls="customers"
                                v-if="customers.data && customers.data.length > 0"
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
    name: 'DataCustomer',
    created() {
        this.getCustomers() //LOAD DATA PELANGGAN KETIKA COMPONENT DI-LOAD
    },
    data() {
        return {
            //FIELD YANG AKAN DITAMPILKAN PADA TABLE DIATAS
            fields: [
                { key: 'nik', label: 'NIK' },
                { key: 'name', label: 'Nama Lengkap' },
                { key: 'address', label: 'Alamat' },
                { key: 'phone', label: 'Telp' },
                { key: 'point', label: 'Poin' },
                { key: 'deposit', label: 'Deposit' },
                { key: 'courier_id', label: 'Invited By' },
                { key: 'actions', label: 'Aksi' }
            ],
            search: ''
        }
    },
    computed: {
        ...mapState('customer', {
            customers: state => state.customers //MENGAMBIL DATA CUSTOMER DARI STATE CUSTOMER
        }),
        //MENGAMBIL DATA PAGE DARI STATE CUSTOMER
        page: {
            get() {
                return this.$store.state.customer.page
            },
            set(val) {
                this.$store.commit('customer/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getCustomers() //KETIKA VALUE PAGE TERJADI PERUBAHAN, MAKA REQUEST DATA BARU
        },
        search() {
            this.getCustomers(this.search) //KETIKA VALUE SEARCH TERJADI PERUBAHAN, MAKA REQUEST DATA BARU
        }
    },
    methods: {
        ...mapActions('customer', ['getCustomers', 'removeCustomer']), 
        //KETIKA TOMBOL HAPUS DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
        deleteCustomer(id) {
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
                    this.removeCustomer(id) //JIKA SETUJU MAKA PERMINTAAN HAPUS AKAN DI EKSEKUSI
                }
            })
        }
    }
}
</script>
