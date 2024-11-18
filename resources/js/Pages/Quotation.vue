<template>
    <div class="container mx-auto p-4">
        <Navbar />
        <h1 class="text-3xl text-center font-bold mb-4">Pantalla de Cotización</h1>

        <div class="mb-4">
            <label
                for="cliente-select"
                class="block text-sm font-medium text-gray-700"
                >Cliente</label
            >
            <select
                id="cliente-select"
                v-model="selectedClient"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
                <option value="">Seleccione un cliente</option>
                <option
                    v-for="cliente in clientes"
                    :key="cliente.id"
                    :value="cliente.id"
                >
                    {{ cliente.nombre }}
                </option>
            </select>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Productos Disponibles</h2>
            <div class="mb-4">
                <label
                    for="search"
                    class="block text-sm font-medium text-gray-700"
                    >Buscar Producto</label
                >
                <input
                    id="search"
                    v-model="searchQuery"
                    type="text"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    placeholder="Ingrese el nombre del producto"
                />
            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4"
            >
                <div
                    v-for="producto in filteredProductos"
                    :key="producto.id"
                    class="border p-4 rounded-md"
                    :class="{ 'opacity-50': producto.stock === 0 }"
                >
                    <div class="relative w-full h-48 mb-4">
                        <img
                            v-if="producto.imageLoaded"
                            :src="`/storage/${producto.image_path}`"
                            :log
                            :alt="producto.nombre"
                            class="w-full h-full object-cover rounded"
                            @load="onImageLoad(producto.id)"
                            @error="onImageError(producto.id)"
                        />
                        <div
                            v-else
                            class="w-full h-full bg-gray-200 rounded flex items-center justify-center"
                        >
                            <span class="text-gray-500">Cargando...</span>
                        </div>
                    </div>
                    <h3 class="font-bold">{{ producto.nombre }}</h3>
                    <p>{{ producto.descripcion }}</p>
                    <p>Precio: ${{ producto.precio }}</p>
                    <p>Stock: {{ producto.stock }}</p>
                    <div class="flex items-center mt-2">
                        <button
                            @click="decrementQuantity(producto.id)"
                            class="bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-8 rounded-l cursor-pointer"
                            :disabled="
                                cantidades[producto.id] <= 0 ||
                                producto.stock === 0
                            "
                        >
                            <span class="m-auto text-2xl font-thin">−</span>
                        </button>
                        <input
                            :id="`cantidad-${producto.id}`"
                            v-model.number="cantidades[producto.id]"
                            type="number"
                            min="0"
                            :max="producto.stock"
                            :disabled="producto.stock === 0"
                            class="outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black md:text-base cursor-default flex items-center text-gray-700"
                            :class="{
                                'bg-gray-200 cursor-not-allowed':
                                    producto.stock === 0,
                            }"
                            name="custom-input-number"
                        />
                        <button
                            @click="incrementQuantity(producto.id)"
                            class="bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-8 rounded-r cursor-pointer"
                            :disabled="
                                cantidades[producto.id] >= producto.stock ||
                                producto.stock === 0
                            "
                        >
                            <span class="m-auto text-2xl font-thin">+</span>
                        </button>
                    </div>

                    <p
                        v-if="cantidades[producto.id] < 0"
                        class="text-red-500 mt-2"
                    >
                        La cantidad no puede ser menor que 0.
                    </p>
                    <p v-if="producto.stock === 0" class="text-red-500 mt-2">
                        Producto agotado
                    </p>
                    <p
                        v-if="cantidades[producto.id] > producto.stock"
                        class="text-red-500 mt-2"
                    >
                        No puede superar el stock disponible ({{
                            producto.stock
                        }}).
                    </p>

                    <button
                        @click="addToCart(producto)"
                        class="mt-2 px-4 py-2 bg-blue-500 text-white rounded"
                        :disabled="
                            cantidades[producto.id] <= 0 ||
                            cantidades[producto.id] > producto.stock
                        "
                    >
                        Añadir al Carrito
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-4 flex space-x-4">
            <button
                @click="openModal"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition-colors"
                :disabled="!selectedClient || cart.length === 0"
            >
                Ver Resumen de Cotización
            </button>

            <button
                v-if="cart.length > 0"
                @click="clearCart"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors"
            >
                Limpiar Carrito
            </button>
        </div>

        <QuoteModal
            v-if="isOpen"
            :is-open="isOpen"
            :cliente-name="selectedClientName"
            :cart="cart"
            :total="total"
            @close="closeModal"
        />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import QuoteModal from "@/components/QuoteModal.vue";
import Navbar from "@/components/navbar.vue";
import axios from "axios";


const isOpen = ref(false);
const clientes = ref([]);
const productos = ref([]);
const cantidades = ref({});
const cart = ref([]);
const searchQuery = ref("");
const selectedClient = ref("");

const updateProductoImageStatus = (productoId, imageUrl = null) => {
    const producto = productos.value.find((p) => p.id === productoId);
    if (producto) {
        producto.image_url = imageUrl;
        producto.imageLoaded = true;
    }
};

const onImageLoad = (productoId) => {
    updateProductoImageStatus(productoId);
};

const onImageError = (productoId) => {
    updateProductoImageStatus(productoId, "/fallback-image.jpg");
};

const openModal = () => {
    if (selectedClient.value && cart.value.length > 0) {
        isOpen.value = true;
    }
};

const closeModal = () => {
    isOpen.value = false;
};

const clearCart = () => {
    cart.value = [];
    Object.keys(cantidades.value).forEach((key) => {
        cantidades.value[key] = 0;
    });
};

const selectedClientName = computed(() => {
    if (!selectedClient.value) return "No seleccionado";
    const cliente = clientes.value.find((c) => c.id === selectedClient.value);
    return cliente ? cliente.nombre : "Cliente no encontrado";
});

const filteredProductos = computed(() => {
    if (!searchQuery.value) {
        return productos.value;
    }
    return productos.value.filter((producto) =>
        producto.nombre.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

onMounted(async () => {
    try {
        const responseClientes = await axios.get("/clientes");
        clientes.value = responseClientes.data;

        const responseProductos = await axios.get("/productos");
        productos.value = responseProductos.data.map((producto) => ({
            ...producto,
            image_url: `/storage/${producto.image_path}`,
            imageLoaded: false,
        }));

        productos.value.forEach((producto) => {
            cantidades.value[producto.id] = 0;
        });
    } catch (error) {
        console.error("Error al cargar datos:", error);
    }
});

const total = computed(() => {
    return cart.value.reduce((acc, item) => {
        return acc + item.cantidad * item.precio;
    }, 0);
});

const addToCart = (producto) => {
    const cantidad = cantidades.value[producto.id];
    if (cantidad > 0 && cantidad <= producto.stock) {
        const item = cart.value.find((item) => item.id === producto.id);
        if (item) {
            item.cantidad += cantidad;
            if (item.cantidad > producto.stock) {
                item.cantidad = producto.stock;
            }
        } else {
            cart.value.push({
                ...producto,
                cantidad,
            });
        }
        cantidades.value[producto.id] = 0;
    } else {
        alert("La cantidad seleccionada no es válida.");
    }
};

const incrementQuantity = (productoId) => {
    const producto = productos.value.find((p) => p.id === productoId);
    if (producto && cantidades.value[productoId] < producto.stock) {
        cantidades.value[productoId]++;
    }
};

const decrementQuantity = (productoId) => {
    if (cantidades.value[productoId] > 0) {
        cantidades.value[productoId]--;
    }
};
</script>
