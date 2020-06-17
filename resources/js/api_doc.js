import Vue from 'vue';
import {Loading} from "buefy/dist/components";
import Http from './modules/Http';
import bulmaAccordion from 'bulma-accordion/dist/js/bulma-accordion.min.js';
import 'buefy/dist/buefy.css';
import 'bulma/css/bulma.css';

window.http = new Http();

Vue.use(Loading);

new Vue({

    el: '#api-doc',

    /**
     * Components
     *
     * @type {Object}
     * @author {goper}
     */
    components: {

    },

    /**
     * Data
     *
     * @type {Object}
     * @author {goper}
     */
    data: {
        content: '',
        previousFile: '',
        currentFile: 'README.md',
        currentPath: '',
        currentFullPath: '',
        mainDirectories: [],
        subDirectories: [],
        isLoading: true,
        doc: {
            request: '',
            route: '',
        },

        version: null
    },

    watch: {
        // whenever question changes, this function will run
        content: function (newContent) {
            this.bindEventsToAnchor();
        },
    },

    /**
     * Methods
     *
     * @type {Object}
     * @author {goper}
     */
    methods: {

        isFile(dir)
        {
            return dir.includes('.');
        },

        getMarkDownContent(file, fromBack = false)
        {
            this.isLoading = true;
            this.previousFile = this.currentFullPath;
            let fullPath = this.currentPath + file;
            if (fromBack)
                fullPath = file;

            this.currentFullPath = fullPath;

            http.getJSON(`/api/documentation/get`, {
                file: fullPath,
                version: this.version
            })
                .then(({data}) => {
                    let {content, path, previousFile} = data;

                    this.content = content;
                    this.currentFile = file;
                    this.currentPath = path;

                    this.fetchDocDetails(data);

                    this.isLoading = false;
                })
                .catch(({data}) => {
                    alert(data.message);
                    this.isLoading = false;
                });
        },

        bindEventsToAnchor()
        {
            for (let link of document.getElementsByTagName('a')) {
                link.addEventListener('click', this.linkIsClick);
            }
        },

        linkIsClick(e)
        {
            if (e.target.matches('.md-link')) {
                event.preventDefault();
                let file = e.target.closest("a").getAttribute('href');

                this.getMarkDownContent(file);
            }
        },

        goBack()
        {
            this.getMarkDownContent(this.previousFile, true);
        },

        setActiveItem(path)
        {
            let files = document.getElementsByClassName('is-file');
            for (let file of files) {
                file.classList.remove('is-active');
                if (file.getAttribute('path') == path) {
                    file.classList.add('is-active');
                }
            }
        },

        fetchDocDetails(data)
        {
            let {details} = data;
            this.doc.request = details.request;
            this.doc.route = details.route;
        },

        jumpToFile(file)
        {
            this.isLoading = true;
            http.getJSON(`/api/documentation/get`, {
                file,
                version: this.version
            }).then(({data}) => {
                    let {content, path, previousFile} = data;

                    this.content = content;
                    this.currentFile = file;
                    this.currentPath = path;
                    this.fetchDocDetails(data);
                    this.setActiveItem(file);
                    this.isLoading = false;
                })
                .catch(({data}) => {
                    alert(data.message);
                    this.isLoading = false;
                });
        },
    },

    mounted()
    {
        this.version = window.apiVersion;
        bulmaAccordion.attach();
        // Fetch initial page
        this.getMarkDownContent('README.md');

    }
});
