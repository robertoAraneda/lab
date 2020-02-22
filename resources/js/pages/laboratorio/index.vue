<template>
    <main class="py-4">
        <div class="text-center">
            <h1 class="display-4 text-bold text-black">Subdepartamento Laboratorio Clínico</h1>
            <p class="lead">Hospital Dr. Hernán Henríquez Aravena</p>
        </div>
        <div class="jumbotron">
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div><label>Catálogo de exámenes</label></div>
                        <div>
                            <form class="form-inline ml-3">
                                <div class="input-group input-group-sm">
                                    <input class="form-control" type="text" placeholder="Buscar exámen"
                                           aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mt-2">
                                <button v-for="letter in searchCatalogLetter" :key="letter" class="letter btn btn-primary">
                                    {{ letter }}
                                </button>
                            </div>
                            <nav class="nav nav-pills nav-sidebar flex-column mt-5">
                                <label>Áreas de trabajo:</label>
                                <li class="nav-item">

                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Bioquimica clínica
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Hematología
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Coagulación
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Inmunología
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Tuberculosis
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Microbiología
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                        Diagnóstico Molecular
                                    </button>
                                    <button class="nav-link btn btn-secondary btn-block text-white">
                                       Test
                                    </button>
                                     <button class="nav-link btn btn-secondary btn-block text-white">
                                       Test
                                    </button>
                                    
                                </li>
                            </nav>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100"
                                         src="../../../../public/dist/img/molecular-biology.jpg"
                                         height="300"
                                         width="900"
                                         alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100"
                                         src="../../../../public/dist/img/antibody.jpg"
                                         height="300"
                                         width="900"
                                         alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100"
                                         src="../../../../public/dist/img/red-blood-cells.jpg"
                                         height="300"
                                         width="900"
                                         alt="First slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <div class="mt-3">
                            <div class="callout callout-danger">
                                <h5>I am a danger callout!</h5>

                                <p>There is a problem that we need to fix. A wonderful serenity has taken possession of
                                    my entire
                                    soul,
                                    like these sweet mornings of spring which I enjoy with my whole heart.</p>
                            </div>
                            <div class="callout callout-info">
                                <h5>I am an info callout!</h5>

                                <p>Follow the steps to continue to payment.</p>
                            </div>
                            <div class="callout callout-warning">
                                <h5>I am a warning callout!</h5>

                                <p>This is a yellow callout.</p>
                            </div>
                            <div class="callout callout-success">
                                <h5>I am a success callout!</h5>

                                <p>This is a green callout.</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <h5 class="info-box-text text-bold ml-2 mt-2">Circulares</h5>
                            </div>
                        </div>
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <h5 class="info-box-text text-bold ml-2 mt-2">Informaciones</h5>
                            </div>
                        </div>
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <h5 class="info-box-text text-bold ml-2 mt-2">Calidad</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
    export default {
        name: "index",
        data() {
            return {
                searchCatalogLetter: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
                    'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '#']
            }
        }

    }
</script>

<style scoped>
    .letter {
        width: 40px;
        height: 40px;
        margin: 2px;
    }

    .jumbotron {
        background-image: url("../../../../public/dist/img/lab-id-solutions-supplies-banner.jpg");
        background-size: cover;
        opacity: 0.8;
    }

</style>
