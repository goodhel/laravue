<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'products.add' }" class="btn btn-primary btn-sm">Tambah</router-link>
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
                <b-table striped hover bordered :items="products.data" :fields="fields" show-empty>
                    <template v-slot:cell(laundry_type)="row">
                        {{ row.item.type.name }}
                    </template>
                    <template v-slot:cell(user_id)="row">
                        {{ row.item.user.name }}
                    </template>
                    <template v-slot:cell(service)="row">
                        {{ row.item.service }} {{ row.item.service_type }}
                    </template>
                    <template v-slot:cell(actions)="row">
                        <router-link :to="{ name: 'products.edit', params: {id: row.item.id} }" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteProduct(row.item.id)"><i class="fas fa-trash"></i></button>
                    </template>
                </b-table>

            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-6">
                        <p v-if="products.data"><i class="fa fa-bars"></i> {{ products.data.length }} item dari {{ products.meta.total }} total data</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <b-pagination
                                v-model="page"
                                :total-rows="products.meta.total"
                                :per-page="products.meta.per_page"
                                aria-controls="products"
                                v-if="products.data && products.data.length > 0"
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
    name: 'DataCourier',
    created() {
        this.getProducts() //MELAKUKAN REQUEST KETIKA COMPONENT DI-LOAD
    },
    data() {
        return {
            //FIELDS UNTUK MENGISI HEADER TABLE YANG AKAN DITAMPILKAN
            fields: [
                { key: 'name', label: 'Nama Item' },
                { key: 'unit_type', label: 'Tipe' },
                { key: 'laundry_type', label: 'Jenis Jasa' },
                { key: 'price', label: 'Harga' },
                { key: 'user_id', label: 'Admin' },
                { key: 'service', label: 'Lama Pengerjaan' },
                { key: 'actions', label: 'Aksi' }
            ],
            //VARIABLE UNTUK FORM SEARCH
            search: ''
        }
    },
    computed: {
        //ME-LOAD STATE DARI MODULE PRODUCTS
        ...mapState('product', {
            products: state => state.products, //STATE PRODUCTS
        }),
        page: {
            get() {
                return this.$store.state.product.page //LOAD STATE PAGE
            },
            set(val) {
                this.$store.commit('product/SET_PAGE', val) //SET STATE PAGE KETIKA VALUE BERUBAH
            }
        }
    },
    watch: {
        //KETIKA TERJADI PERUBAHAN VALUE DARI PAGE
        page() {
            this.getProducts() //AMBIL DATA TERBARU
        },
        //KETIKA TERJADI PERUBAHAN VALUE DARI SEARCH
        search() {
            this.getProducts(this.search) //AMBIL DATA TERBARU BERDASARKAN VALUE SEARC
        }
    },
    methods: {
      ...mapActions('product', ['getProducts', 'removeProduct']), //LOAD ACTIONS DARI MODULE PRODUCT
        //FUNGSI UNTUK MENG-HANDLE TOMBOL HAPUS PRODUCT
        deleteProduct(id) {
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
                    this.removeProduct(id) //KETIKA YES MAKA FUNGSI INI AKAN DIJALANKAN
                }
            })
        }
    }
}
</script>