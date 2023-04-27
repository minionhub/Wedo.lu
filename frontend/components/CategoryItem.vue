<template>
  <div class="p-0">
    <div class="row ml-2">
      <b-img :src="source" style="width: 30px;" alt="img"></b-img>
      <p
        class="my-auto ml-2"
        style="color: #5c5c68; font-size: 18px; line-height: 22px; font-weight: 500; font-family: 'open sans', sans-serif"
      >
        {{ categoryName }}
      </p>
    </div>
    <hr />
    <div class="row">
      <div class="col-4">
        <ul
          style="color: #5c5c68; font-size: 14px; line-height: 18px; font-weight: 500; list-style-type: none; font-family: 'open sans', sans-serif"
          class="pl-0"
        >
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
        </ul>
      </div>
      <div class="col-4">
        <ul
          style="color: #5c5c68; font-size: 14px; line-height: 18px; font-weight: 500; list-style-type: none; font-family: 'open sans', sans-serif"
          class="pl-0"
        >
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
        </ul>
      </div>
      <div class="col-4">
        <ul
          style="color: #5c5c68; font-size: 14px; line-height: 18px; font-weight: 500; list-style-type: none; font-family: 'open sans', sans-serif"
          class="pl-0"
        >
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
          <SubCategoryItem
            :sub-category-name="subCategoryName"
          ></SubCategoryItem>
        </ul>
      </div>
    </div>
    <hr />
  </div>
</template>

<script>
import SubCategoryItem from '../components/SubCategoryItem'

export default {
  name: 'CategoryItem',
  components: { SubCategoryItem },
  props: ['source', 'categoryName', 'subCategoryName']
}
</script>

<style scoped></style>
