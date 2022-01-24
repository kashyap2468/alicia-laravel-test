<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Images</div>

                    <div class="card-body">
                        <div id="loaderShow">
                            <img src="images/loader.gif" alt="">
                        </div>
                        <div
                            :class="imagesListData.is_show"
                            v-for="imagesListData in imagesList"
                            :key="imagesListData.id"
                        >
                            <div class="col-lg-4 imagingList" style="float: left">
                                <img
                                    class="listedImg"
                                    :src="imagesListData.url"
                                    :id="imagesListData.id"
                                />
                                <button
                                    v-if="!imagesListData.isFavourite"
                                    class="btn btn-success btn-sm addFavourite"
                                    @click="addToFavourite(imagesListData.id,imagesListData.indexId)"
                                >
                                    Add to favourite
                                </button>
                                <button
                                    v-if="imagesListData.isFavourite"
                                    class="btn btn-danger btn-sm removeFavourite"
                                    @click="removeFavourite(imagesListData.id,imagesListData.indexId)"
                                >
                                    Remove favourite
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" @click="loadMore()">
                            Load More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var appPath = process.env.MIX_APP_URL;
    export default {
        props: ["myfavourites"],
        data() {
            return {
                imagesList: [],
                defaultShow: 9,
            };
        },
        created() {
            axios
                .get("https://jsonplaceholder.typicode.com/photos")
                .then((response) => {
                    $('#loaderShow').hide();
                    var imagesList = response.data;
                    var favouriteList = this.myfavourites;
                    for (var i = 0; i < imagesList.length; i++) {
                        imagesList[i]["indexId"] = i;
                        var isShow = "d-block";
                        if (i > 9) {
                            isShow = "d-none";
                        }
                        imagesList[i]["is_show"] = isShow;
                        var isFavourite = 0;
                        if (jQuery.inArray(imagesList[i]["id"], favouriteList) !== -1) {
                            isFavourite = 1;
                        }
                        imagesList[i]["isFavourite"] = isFavourite;
                    }
                    this.imagesList = imagesList;
                });
        },
        methods: {
            getmyFavourite() {
                return (this.myfavourites = JSON.parse(this.myfavourites));
            },
            loadMore() {
                var imagesList = this.imagesList;
                var count = this.defaultShow + 10;
                var favouriteList = this.myfavourites;
                for (var i = 0; i < imagesList.length; i++) {
                    imagesList[i]["indexId"] = i;
                    var isShow = "d-block";
                    if (i > count) {
                        isShow = "d-none";
                    }
                    imagesList[i]["is_show"] = isShow;

                    var isFavourite = 0;
                    if (jQuery.inArray(imagesList[i]["id"], favouriteList) !== -1) {
                        isFavourite = 1;
                    }
                    imagesList[i]["isFavourite"] = isFavourite;
                }
                this.imagesList = imagesList;
                this.defaultShow = count;
            },
            addToFavourite(imageId, indexId) {
                var imagesList = this.imagesList;
                axios
                    .get(appPath + "/addImagetoFavourite/" + imageId)
                    .then((response) => {
                        if (response.data.status == 200) {
                            imagesList[indexId]["isFavourite"] = 1;
                            this.imagesList = imagesList;
                            this.$toasted.success("Image has been add to favourite");
                        }
                        if (response.data.is_login == 0) {
                            //window.location.href = '/login'
                            $("#myModal").modal("show");
                            this.$toasted.warning("Please login to avail this function");
                        }
                    });
            },
            removeFavourite(imageId, indexId) {
                var imagesList = this.imagesList;
                axios
                    .get(appPath + "/removeImageFavourite/" + imageId)
                    .then((response) => {
                        if (response.data.status == 200) {
                            this.myfavourites = response.data.myfavourites;
                            imagesList[indexId]["isFavourite"] = 0;
                            this.imagesList = imagesList;
                            this.$toasted.success("Image has been removed from favourite");
                        }
                        if (response.data.is_login == 0) {
                            //window.location.href = '/login'
                            $("#myModal").modal("show");
                            this.$toasted.warning("Please login to avail this function");
                        }
                    });
            },
        },
    };
</script>
