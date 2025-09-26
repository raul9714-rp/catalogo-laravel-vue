<template>
  <transition name="fade">
    <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <!-- Overlay de carga -->
      <div
        v-if="cargando"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white p-4 rounded shadow text-center">
          Guardando producto...
        </div>
      </div>

      <div
        class="bg-white rounded-lg shadow-lg p-6 w-96 relative z-10 transform transition-all duration-300 scale-95 opacity-0"
        :class="{ 'opacity-100 scale-100': visible }"
      >
        <h2 class="text-xl font-bold mb-4">
          {{ form.id ? "Editar Producto" : "Agregar Producto" }}
        </h2>

        <!-- Código -->
        <p>Codigo</p>
        <input
          v-model="form.codigo"
          type="text"
          placeholder="Código de producto"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.codigo" class="text-red-500 text-sm">{{ errores.codigo }}</p>

        <!-- Nombre -->
        <p>Nombre</p>
        <input
          v-model="form.nombre"
          type="text"
          placeholder="Nombre de producto"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.nombre" class="text-red-500 text-sm">{{ errores.nombre }}</p>

        <!-- Descripción -->
        <p>Decripcion</p>
        <textarea
          v-model="form.descripcion"
          placeholder="Descripción"
          class="border p-2 w-full mb-2"
        ></textarea>

        <!-- Precio -->
        <p>Precio:</p>
        <input
          v-model="form.precio"
          type="number"
          step="0.01"
          placeholder="Precio"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.precio" class="text-red-500 text-sm">{{ errores.precio }}</p>

        <!-- Stock -->
        <p>Stock</p>
        <input
          v-model="form.stock"
          type="number"
          placeholder="Stock"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.stock" class="text-red-500 text-sm">{{ errores.stock }}</p>

        <!-- Fotografía -->
        <p>Fotografia</p>
        <input
          type="file"
          accept="image/jpeg,image/jpg,image/png,image/gif"
          @change="handleFileUpload"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.fotografia" class="text-red-500 text-sm">{{ errores.fotografia }}</p>

        <!-- Fechas -->
         
        <p>Fecha de Ingreso</p>
        <input
          v-model="form.fecha_ingreso"
          type="date"
          class="border p-2 w-full mb-2"
        />
        <p v-if="errores.fecha_ingreso" class="text-red-500 text-sm">{{ errores.fecha_ingreso }}</p>

        <p>Fecha de Vencimiento</p>
        <input
          v-model="form.fecha_vencimiento"
          type="date"
          class="border p-2 w-full mb-4"
        />
        <p v-if="errores.fecha_vencimiento" class="text-red-500 text-sm">{{ errores.fecha_vencimiento }}</p>

        <!-- Botones -->
        <div class="flex justify-end space-x-2">
          <button
            @click="cerrar"
            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
          >
            Cancelar
          </button>
          <button
            @click="guardar"
            :disabled="cargando"
            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
          >
            {{ cargando ? "Guardando..." : "Guardar" }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";

export default {
  props: ["visible", "producto"],
  data() {
    return {
      form: {
        id: null,
        codigo: "",
        nombre: "",
        descripcion: "",
        precio: "",
        stock: "",
        fotografia: null,
        fecha_ingreso: "",
        fecha_vencimiento: "",
      },
      errores: {},
      cargando: false,
    };
  },
  watch: {
    producto: {
      immediate: true,
      handler(val) {
        if (val) {
          this.form = { ...val, fotografia: null };
        } else {
          this.resetForm();
        }
      },
    },
  },
  methods: {
    resetForm() {
      this.form = {
        id: null,
        codigo: "",
        nombre: "",
        descripcion: "",
        precio: "",
        stock: "",
        fotografia: null,
        fecha_ingreso: "",
        fecha_vencimiento: "",
      };
      this.errores = {};
    },
    cerrar() {
      this.resetForm();
      this.$emit("close");
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) {
        this.form.fotografia = null;
        return;
      }

      if (file.size > 1.5 * 1024 * 1024) {
        this.errores.fotografia = "La imagen no debe superar 1.5 MB";
        this.form.fotografia = null;
        return;
      }

      const validTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
      if (!validTypes.includes(file.type)) {
        this.errores.fotografia = "Formato no permitido (jpeg, jpg, png, gif)";
        this.form.fotografia = null;
        return;
      }

      this.errores.fotografia = null;
      this.form.fotografia = file;
    },
    async guardar() {
      this.cargando = true;
      this.errores = {};

      if (!this.form.codigo.match(/^[a-zA-Z0-9]+$/)) {
        this.errores.codigo = "El código solo puede tener letras y números";
      }
      if (!this.form.nombre.match(/^[a-zA-Z\s]+$/)) {
        this.errores.nombre = "El nombre solo puede contener letras y espacios";
      }
      if (
        this.form.fecha_ingreso &&
        this.form.fecha_vencimiento &&
        this.form.fecha_ingreso > this.form.fecha_vencimiento
      ) {
        this.errores.fecha_vencimiento =
          "La fecha de vencimiento debe ser mayor a la de ingreso";
      }

      if (Object.keys(this.errores).length > 0) {
        this.cargando = false;
        return;
      }

      try {
        let formData = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (this.form[key] !== null) {
            formData.append(key, this.form[key]);
          }
        });

        if (this.form.id) {
          await axios.post(
            `http://localhost:8080/api/productos/${this.form.id}?_method=PUT`,
            formData,
            { headers: { "Content-Type": "multipart/form-data" } }
          );
          alert("Producto actualizado correctamente");
        } else {
          await axios.post("http://localhost:8080/api/productos", formData, {
            headers: { "Content-Type": "multipart/form-data" },
          });
          alert("Producto creado correctamente");
        }

        this.$emit("saved");
        this.cerrar();
      } catch (error) {
        console.error(error);
        alert("Error al guardar producto");
      } finally {
        this.cargando = false;
      }
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
.fade-enter-to,
.fade-leave-from {
  opacity: 1;
  transform: scale(1);
}
</style>
