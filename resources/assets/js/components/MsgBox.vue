<template>

  <ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large fadeInUp" >
    <li><span class="dropdown-header ">未读消息</span></li>
    <li>
      <div class="drop-down-wrapper ">
        <ul>
          <li class="unread" v-for="item in items">
            <a href="#" class="unread">
              <div class="clearfix">
                <div class="thread-image">
                  <img :src="item.avatar" class="img-responsive img-rounded">
                </div>
                <div class="thread-content">
                  <span class="author">
                    {{item.from}}
                  </span>
                  <span class="preview">
                    {{item.content}}
                  </span>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="view-all"><a href="">查看全部</a></li>
  </ul>
</template>
<script>
  export default{
    props: ['api'],
    data: function () {
      return {
        items: {}
      }
    },
    ready: function () {
      this.$http.get(this.api)
      .then(function (response) {
        this.items = response.data
      })
    }
}
</script>

<style>
 .preview{
  color: #000 !important;
 }
</style>