var sponsoredJobFlow = new Moon({
  el: "#sponsored_job_flow",

  data: {
    firstName: "",
    shortDescription: "",
    positionType: undefined,
    requiredSkills: "",
    learnMoreLink: "",
    proceedToNextStep: false
  },

  computed: {

    shouldShowFullPreview: {
      get: function () {
        var name = this.get('firstName');

        if (name && name.length >= 1) {
          return 'Preview--fullOpacity';
        }

      }
    },

    shouldShowLearnMoreLink: {
      get: function () {
        var link = this.get('learnMoreLink');

        if (link && link.length >=1) {
          return 'show';
        }
      }
    },

    positionTypeDisplayText: {
      get: function () {
        var positionType = this.get('positionType');

        if (typeof positionType === "undefined") {
          return "";
        } else {
          return positionType;
        }
      }
    },

    showOrHideDurationClass: {
      get: function () {
        var positionType = this.get('positionType');

        if (positionType === 'Freelance') {
          return '';
        } else {
          return 'hide';
        }
      }
    },

    goToNextStepClass: {
      get: function () {
        var next = this.get('proceedToNextStep');

        return next ? 'isPurchase' : '';
      }
    },

    doesAnyFieldHaveAValue: {
      get: function () {

        var props = [this.get('firstName'), this.get('shortDescription'), this.get('positionType'), this.get('requiredSkills')];

        var results = false;

        for (var i = 0; i < props.length; i + =1) {
          var prop = props[i];

          if (typeof prop !== "undefined" || prop.length >= 1) {
            results = true;
          }
        }

        return results;

      }
    },

    doAllFieldsHaveValue: {
      get: function () {
        var props = [this.get('firstName'), this.get('shortDescription'), this.get('positionType'), this.get('requiredSkills')];

        var results = true;

        for (var i = 0; i  < props.length; i += 1) {
          var prop = props[i];

          if (typeof prop === "undefined" || prop.length < 1) {
            results = false;
          }

        }

        return results;

      }
    },

    enableButtonClass: {
      get: function () {
        var results = this.get('requiredFieldsFilled');
        return results ? '' : 'disabled';
      }
    }
  },

  hooks: {
    mounted: function () {

      card = elements.create('card', {style: style});

      // Add an instance of the card Element into the `card-element` <div>
      card.mount('#card-element');

    }
  },

  methods: {
    nextStep: function () {

      // var requiredFieldsFilled = this.get('requiredFieldsFilled');

      // if (requiredFieldsFilled) {
        this.set('proceedToNextStep', true);
      //}

    },

    purchase: function () {

      console.log("Purchase.");
      console.log("card", card);

      stripe.createToken(card).then(function(result) {

        // Handle result.error or result.token
        console.log("What's the result?", result);

        if (result.error) {
          return;

          // result.error.message
        }

        if (result.token) {

          // Save the token into firebase.
          var chargesRef = firebase.database().ref("test_charges");

          chargesRef.push().set({
            "token": result.token
          });

        }

      });

    }
  }

});
