<template>
  <div class="container mx-auto p-6">
    <!-- Overlay de carga -->
    <div
      v-if="cargando"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-4 rounded shadow text-center">
        Cargando productos...
      </div>
    </div>

    <button
      @click="abrirCrear"
      class="bg-green-600 text-white px-4 py-2 rounded mb-4"
    >
      Agregar Producto
    </button>

    <ProductoForm
      :visible="mostrarModal"
      :producto="productoSeleccionado"
      @close="cerrarModal"
      @saved="cargarProductos"
    />

    <h1 class="text-2xl font-bold mb-4">Lista de Productos</h1>

    <table class="w-full border-collapse border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-3 py-2">Código</th>
          <th class="border px-3 py-2">Nombre</th>
          <th class="border px-3 py-2">Precio</th>
          <th class="border px-3 py-2">Stock</th>
          <th class="border px-3 py-2">Foto</th>
          <th
            class="border px-3 py-2 cursor-pointer text-blue-600"
            @click="toggleSort"
          >
            Fecha de ingreso
            <span v-if="sort === 'asc'">▲</span>
            <span v-else>▼</span>
          </th>
          <th class="border px-3 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="p in productos"
          :key="p.id"
          class="hover:bg-gray-50"
        >
          <td class="border px-3 py-2">{{ p.codigo }}</td>
          <td class="border px-3 py-2">{{ p.nombre }}</td>
          <td class="border px-3 py-2">${{ p.precio }}</td>
          <td class="border px-3 py-2">{{ p.stock }}</td>
          <td class="border px-3 py-2 text-center">
            <img
              v-if="p.fotografia"
              :src="'/storage/' + p.fotografia"
              class="h-12 w-12 object-cover mx-auto"
            />
          </td>
          <td class="border px-3 py-2">{{ formatDate(p.created_at) }}</td>
          <td class="border px-3 py-2 text-center space-x-2">
            <button
              @click="abrirEditar(p)"
              class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
            >
              Editar
            </button>
            <button
              @click="eliminarProducto(p.id)"
              class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
            >
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación -->
    <div class="flex justify-between items-center mt-4">
      <button
        :disabled="!pagination.prev_page_url"
        @click="cargarProductos(pagination.prev_page_url)"
        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
      >
        « Anterior
      </button>

      <span>Página {{ pagination.current_page }} de {{ pagination.last_page }}</span>

      <button
        :disabled="!pagination.next_page_url"
        @click="cargarProductos(pagination.next_page_url)"
        class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
      >
        Siguiente »
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ProductoForm from "./ProductoForm.vue";

export default {
  components: { ProductoForm },
  data() {
    return {
      productos: [],
      pagination: {},
      sort: "desc",
      mostrarModal: false,
      productoSeleccionado: null,
      cargando: false,
    };
  },
  mounted() {
    this.cargarProductos();
  },
  methods: {
    async cargarProductos(url = null) {
      this.cargando = true;
      try {
        const response = await axios.get(
          url || `http://localhost:8080/api/productos?sort=${this.sort}`
        );
        this.productos = response.data.data;
        this.pagination = response.data;
      } catch (error) {
        console.error("Error al cargar productos:", error);
      } finally {
        this.cargando = false;
      }
    },
    toggleSort() {
      this.sort = this.sort === "asc" ? "desc" : "asc";
      this.cargarProductos();
    },
    abrirCrear() {
      this.productoSeleccionado = null;
      this.mostrarModal = true;
    },
    abrirEditar(producto) {
      this.productoSeleccionado = producto;
      this.mostrarModal = true;
    },
    cerrarModal() {
      this.mostrarModal = false;
      this.productoSeleccionado = null;
    },
    async eliminarProducto(id) {
      if (!confirm("¿Seguro que quieres eliminar este producto?")) return;
      this.cargando = true;
      try {
        await axios.delete(`http://localhost:8080/api/productos/${id}`);
        alert("Producto eliminado correctamente");
        this.cargarProductos();
      } catch (error) {
        console.error("Error al eliminar producto:", error);
      } finally {
        this.cargando = false;
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString("es-ES");
    },
  },
};
</script>
