<template>
  <li>
    <p>
      <a href="#" class="link-gray-orange"
        ><i class="material-icons align-bottom" style="color: #FFA601">
          keyboard_arrow_right </i
        >{{ subCategoryName }}</a
      >
    </p>
  </li>
</template>

<script>
export default {
  subCategoryName: {
    type: String,
    default: ''
  },
  name: 'SubCategoryItem'
}
</script>

<style scoped></style>
