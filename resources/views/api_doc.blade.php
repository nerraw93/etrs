<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME', 'APP')}} API Documentation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon.png">

    <link href="{{ mix('css/api_documentation.css') }}" type="text/css" rel="stylesheet" />
</head>
<body>

    <div id="api-doc">
        <section class="hero is-primary">
            <div class="hero-body">
                <div class="columns">
                    <div class="column is-12">
                        <div class="container content is-fluid">
                            <i class="is-large fab fa-discord"></i>
                            <i class="is-large fas fa-code"></i>
                            <h1 class="title">{{env('APP_NAME', 'APP')}} API Reference</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- accordion -->
        <section class="accordions">

        </section>
        <!-- END -->

        <section class="section">
            <div class="container is-fluid">
                <div class="columns">
                    <div class="column is-3">
                        <aside class="is-medium menu">
                            <p class="menu-label">
                                Modules
                            </p>
                            <div class="accordions">

                                @foreach ($directories as $directoryKey => $directory)
                                    @if ($directoryKey != '')
                                        <article class="accordion">
                                            <div class="accordion-header">
                                                <p class="is-capitalized">{{$directoryKey}}</p>
                                                <button class="toggle" aria-label="toggle"></button>
                                            </div>
                                            <div class="accordion-body">
                                                <div class="accordion-content">
                                                    <!-- Seed files  -->
                                                    <ul class="list">
                                                        @foreach ($directory as $file)
                                                            @php $path = $directoryKey . '/' . $file . '.md'; @endphp
                                                            <li path="{{$path}}" class="list-item is-capitalized is-file" @click="jumpToFile('{{$path}}')">{{$file}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </article>
                                    @else
                                        @foreach ($directory as $file)
                                            @php $path = $directoryKey . '/' . $file . '.md'; @endphp
                                            <article class="accordion"  @click="jumpToFile('{{$path}}')">
                                                <div class="accordion-header is-file {{$file == 'README' ? 'is-active' : ''}}" path="{{$path}}">
                                                    <p class="is-capitalized">{{$file}}</p>
                                                </div>
                                                <div class="accordion-body">
                                                </div>
                                            </article>
                                        @endforeach
                                    @endif
                                @endforeach

                            <!-- <p class="menu-label">
                                More to read...
                            </p>
                            <ul class="menu-list">
                                <li><span class="tag is-white is-medium">Lorem</span></li>
                                <li><span class="tag is-white is-medium">Ipsum</span></li>
                            </ul> -->
                        </aside>
                    </div>
                    <div class="column is-9">
                        <div class="content is-medium">
                            <div class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <h3 class="title is-3" v-show="doc.request != '' && doc.route != ''">
                                            <span class="tag is-info is-large" v-text="doc.request"></span>
                                            <span v-text="doc.route"></span>
                                        </h3>
                                    </div>

                                </div>
                                <div class="level-right">
                                    <div class="level-item">

                                        <!-- <button class="button is-medium" @click="goBack" v-show="currentFile != 'README.md'">Go back</button> -->
                                    </div>

                                </div>
                            </div>

                            <div class="box" @click="linkIsClick">
                                <b-loading :is-full-page="true" :active="isLoading"
                                    :can-cancel="false"></b-loading>
                                <!-- <h4 id="const" class="title is-6">Send reset password code via email.</h4> -->
                                <div class="api-content" v-html="content">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        window.apiVersion = "{{ $version }}"
    </script>
    <script src="{{ mix('js/api_doc.js') }}" type="text/javascript"></script>

</body>
</html>
