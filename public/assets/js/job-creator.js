(function () {




  var JOBCREATOR = new Vue({

    el: "#JOBCREATOR",

    data: {

      projectType: "",
      jobKeyword: "",
      folderLocation: "",
      fileName: "",
      jobTitle: data.job.job_title,
      technologies: data.tech,
      positionType: data.position,
      contactLink: "",
      projectDuration: "",
      company: data.job.company,
      source: data.job.source,
      budget: "",
      location: "",
      jobHTML: data.job.job_html,
      contactText: "",
      isShowingJobPreview: false,
      tags: "", 
      jobOriginalPostDate: data.job.post_date,
      position_type: data.position, 
    },

    computed: {
      /*
       * @return Array */
      tagsFormatted: function () {
        return this.tags && this.tags.length >= 1 ? this.tags.split(",") : [];
      }
    },

    methods: {

      showJobPreviewPage: function () {
        this.isShowingJobPreview = true;
      },

      hideJobPreviewPage: function () {
        this.isShowingJobPreview = false;
      }
    }

  });

}());
