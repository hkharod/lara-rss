(function () {




  var JOBCREATOR = new Vue({

    el: "#JOBCREATOR",

    data: {

      projectType: "",
      jobKeyword: "",
      folderLocation: "",
      fileName: "",
      jobTitle: data.job.job_title,
      technologies: "",
      positionType: "",
      contactLink: data.job.url,
      projectDuration: "",
      company: "",
      source: "",
      budget: "",
      location: "",
      jobHTML: "",
      contactText: "",
      isShowingJobPreview: false,
      tags: "", 
      jobOriginalPostDate: "",
      position_type: "",
      email_title: data.email.title,
      email_id: data.email.id,
      job_id: data.job.id 
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
