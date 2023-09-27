<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
const showingNavigationDropdown = ref(false);


</script>

<script>

export default {

props:{
    product:[],
},

data(){
    return {
        cartTotal: 0,
        cart:[],
        productArray:[],
        itemCount: 0,
        totalPrice:0,
   
    }
},

setup(){
    const count = ref(0)
    return {
        count
    }
},
mounted(){
   
    this.getItemFromLocalStorage();
    const storedProducts = localStorage.getItem('productArray');
    if(storedProducts){
        this.productArray = JSON.parse(storedProducts)
        this.productArray.itemTotal = 0
    }
        for (let i = 0; i <  this.productArray.length ; i++) {
            if(this.productArray[i].id == this.product.id){
               this.itemCount += 1
            }
        }
        if(this.itemCount > 0){

        }else{
            this.productArray.push(this.product)
        }
        localStorage.setItem('productArray',JSON.stringify(this.productArray))
},

methods:{
    addProduct(){
        this.cartTotal+=parseInt(this.product.price)
        this.saveItemToLocalStorage(this.cartTotal)
    },
    deductProduct(){
        if(this.cartTotal < 1){
            this.cartTotal = 0
        }else{
            this.cartTotal-=this.product.price
            this.saveItemToLocalStorage(this.cartTotal)
        }
    },

    saveItemToLocalStorage(x){
      localStorage.setItem('cartTotal',x)
    },

    getItemFromLocalStorage(){
      const storedTotal = localStorage.getItem('cartTotal');
      if(storedTotal){
        this.cartTotal = parseInt(storedTotal)
      }
    },

   //GrandTotals
    addIndividualItemPriceTotal(itemPrice,product_id){

        console.log('the price', this.totalPrice);
        for(let i = 0;i < this.productArray.length;i++){
            if(product_id == this.productArray[i].id){
                this.totalPrice += itemPrice;
                console.log('THE GRAND TOTAL',this.totalPrice)
            }
        }
    },

    deductIndividualItemPriceTotal(itemPrice,product_id){
        console.log('the price', this.totalPrice);
        for(let i = 0;i < this.productArray.length;i++){
            if(product_id == this.productArray[i].id){
                if( this.totalPrice > 0){
                    this.totalPrice -= itemPrice;
                     console.log('THE GRAND TOTAL',this.totalPrice)
                }
              
            }
        }
    
  },

  //individualTotals
      
    addIndividualItemPrice(itemPrice, product_id) {
        
        for (let i = 0; i < this.productArray.length; i++) {
            if (product_id == this.productArray[i].id) {
                this.productArray[i].itemTotal = (this.productArray[i].itemTotal || 0) + itemPrice;
            }
        }

        this.addIndividualItemPriceTotal(itemPrice,product_id);
    },  


    deductIndividualItemPrice(itemPrice, product_id) {
        
        for (let i = 0; i < this.productArray.length; i++) {
            if (product_id == this.productArray[i].id) {
                if(this.productArray[i].itemTotal > 0){
                    this.productArray[i].itemTotal = (this.productArray[i].itemTotal || 0) - itemPrice;
                    this.deductIndividualItemPriceTotal(itemPrice,product_id)
                }
            
            }
        }
       
    },  


}

}
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    DashboardINDEX
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <!-- {{ $page.props.auth.user.name }} -->

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                <!-- {{ $page.props.auth.user.name }} -->
                            </div>
                            <!-- <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div> -->
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <br>
             
            <!-- Page Content -->
            <main>
                <div>
                    <div class="py-12">

                        <!-- <div class="row">
                            <div class="col">
                                <div v-for="(item, index) in productArray" :key="index" class="card" style="width: 18rem;">
                                    <br>
                                    <br>
                                    <img  v-bind:src="item.filename" class="card-img-top">
                                    <div class="card-body">
                                        <button 
                                        @click="addIndividualItemPrice(item.price)"
                                        class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Add</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="max-w-7xl mx-auto sm:px-8 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                                    <div v-for="(item, index) in productArray" :key="index">
                                        <div class="shadow sm:rounded-lg border-1 border-gray-500 py-10  flex flex-col items-center justify-between bg-gray-100">
                                            <span >name</span>
                                            <img class="border-1 border-green-800 rounded-lg" style="" v-bind:src="item.filename">
                                            <div class="mt-4"> <!-- Add margin-top for spacing -->
                                                <p class="text-lg font-semibold text-green-600">PRICE: R {{ item.price }}</p>
                                                <p class="text-lg font-semibold text-green-600">Item total: R{{ item.itemTotal }}</p>
                                                <div class="space-x-2 mt-2"> <!-- Add margin-top and space between buttons -->
                                                    <button @click="addIndividualItemPrice(item.price,item.id)" class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">+</button>
                                                    <button @click="deductIndividualItemPrice(item.price,item.id)" class="inline-flex items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">-</button>
                                                    <br>
                                                <br>
                                                Amount:
                                                <input
                                                    type="text"
                                                    class="w-20 px-1 py-1 border-2  border-green-400 rounded-md text-gray-700 bg-white-300 cursor-not-allowed"
                                                    placeholder=""
                                                    disabled
                                                    />
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- <br>
                                <ul>
                                    <li  v-for="(item, index) in productArray" :key="index"><img style="height: 100px;" v-bind:src="item.filename">
                                            <button  @click="item.price += item.price">add   {{ item.price }}</button>
                                            <button @click="addIndividualItemPrice(item.price)">function   {{ item.price }}</button>
                                        <br>
                                            <button @click="removeIndividualItemPrice(item.price)">remove</button>
                                    </li>
                                </ul>
                                <br>
                                    <div> <span>Total Price = {{this.cartTotal}}</span></div>
                                <br>
                                <br>
                                    <button @click="count++">{{count}}</button>
                                <br>
                                    <button @click="addProduct()">CLICKTOADD</button>
                                <br>
                                    <button @click="deductProduct()">DEDUCT</button> -->
                            </div>
                        </div> 
                   </div>
                </div>
                <slot />
            </main>
        </div>
    </div>


</template>
