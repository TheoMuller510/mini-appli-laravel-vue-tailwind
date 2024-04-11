<script setup>
import { ref } from 'vue';
import axios from "axios";

const products = ref([]);
const product = ref({
    name: '',
    description: '',
    category: '',
    image: 'test.jpg',
});
const editMode = ref(false);


axios.get('/api/products')
    .then(function(response) {
        products.value = response.data;
    });

const addProduct = () => {
    axios.post('/api/products', product.value)
        .then(function(response) {
            products.value.unshift(response.data);
            resetProduct();
        })
};

const editProduct = (editedProduct) => {
    product.value = { ...editedProduct };
    editMode.value = true;
};

const updateProduct = () => {
    axios.put(`/api/products/${product.value.id}`, product.value)
        .then(function(response) {
            const index = products.value.findIndex(p => p.id === product.value.id);
            products.value.splice(index, 1, response.data);
            resetProduct();
        });
};

const deleteProduct = (deletedProduct) => {
    axios.delete(`/api/products/${deletedProduct.id}`)
        .then(() => {
            products.value = products.value.filter(p => p.id !== deletedProduct.id);
        });
};

const saveButton = () => {
    if (editMode.value) {
        updateProduct();
        editMode.value = false;
    } else {
        addProduct();
    }
};

const changeMode = () => {
    editMode.value = !editMode.value;
    resetProduct();
};

const resetProduct = () => {
    product.value = {
        name: '',
        description: '',
        category: '',
        image: ''
    };
};

</script>

<template>
    <div class="container">
        <div class="row flex justify-center space-x-20 mx-8">
            <div class="col-md-4">
               <div class="flex">
				<h2 class="font-bold uppercase text-4xl">Ajoutez un <br/> article</h2>
			</div>
                <div class="card-body">
                    <form @submit.prevent="saveButton" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 mt-5">
                            <input type="text" v-model="product.name" class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" placeholder="Nom de l'article">
                        </div>
                        <div class="form-group">
                            <textarea type="textarea" v-model="product.description" class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" placeholder="Description de l'article" />
                        </div>
                        <div class="form-group">
                            <input type="text" v-model="product.category" class="w-full bg-gray-100 text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline" placeholder="Catégorie de l'article">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" v-on:change="product.image" class="form-control-file">
                        </div>
                        <div class="flex space-x-2 mt-2">
                        <button type="submit" class="uppercase text-sm font-bold tracking-wide bg-blue-900 text-gray-100 p-3 rounded-lg w-full 
                      focus:outline-none focus:shadow-outline">Enregistrer</button>  
                        <button class="uppercase text-sm font-bold tracking-wide bg-red-600 text-gray-100 p-3 rounded-lg w-full 
                      focus:outline-none focus:shadow-outline" @click="changeMode()" v-if="editMode">Annuler</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="flex">
				<h2 class="font-bold uppercase text-4xl mb-2">Liste des <br/> article</h2>
			</div>
                <table class="border-separate border border-slate-500 border-spacing-1">
                    <thead>
                        <tr>
                            <th scope="col" class="border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Article</th>
                            <th scope="col" class="border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Description</th>
                            <th scope="col" class="border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Catégorie</th>
                            <th scope="col" class="border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">Image</th>
                            <th scope="col" class="border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50 flex justify-center">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td class="p-4 border-b border-blue-gray-50">{{ product.name }}</td>
                            <td class="p-4 border-b border-blue-gray-50">{{ product.description }}</td>
                            <td class="p-4 border-b border-blue-gray-50">{{ product.category }}</td>
                            <td class="p-1 border-b border-blue-gray-50"><img src="https://source.unsplash.com/random/100x100?appartment" :alt="product.name"></td>
                            <td class="p-1 border-b border-blue-gray-50">
                                <div class="space-x-1 text-center">
                                <button type="button"  @click="editProduct(product)"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg></button>
                                <button type="button"  @click="deleteProduct(product)"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>