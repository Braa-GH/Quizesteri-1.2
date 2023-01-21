

//input quiz title length counter
    let titleLength = document.querySelector("#title-length");
    let quizTitle = document.querySelector("#quiz-title");
    let maxlength = quizTitle.getAttribute("maxlength");
    titleLength.innerHTML = maxlength;
    quizTitle.oninput = function () {
        let count = maxlength - this.value.length
        titleLength.innerHTML = count.toString();
        count <= 10 ? titleLength.classList.add("text-danger") : titleLength.classList.remove("text-danger");
    }

//input quiz desc length counter
    let descLength = document.querySelector("#desc-length");
    let quizDesc = document.querySelector("#quiz-desc");
    let descMaxlength = quizDesc.getAttribute("maxlength");
    descLength.innerHTML = descMaxlength;
    quizDesc.oninput = function () {
        let count = descMaxlength - this.value.length
        descLength.innerHTML = count.toString();
        count <= 10 ? descLength.classList.add("text-danger") : descLength.classList.remove("text-danger");
    }

    //range
    let minTime = document.getElementById("minTime");
    let maxTime = document.getElementById("maxTime");
    let quizTime = document.getElementById("time");
    let timeValue = document.getElementById("timeValue");
    minTime.innerHTML = quizTime.getAttribute("min");
    maxTime.innerHTML = quizTime.getAttribute("max");
    timeValue.innerHTML = quizTime.value + " minutes";
    quizTime.oninput = function () {
        timeValue.innerHTML = this.value + " minutes";
    }


    //operation btns
    let btnCancel = document.getElementById("cancel");

    let div = document.getElementById("div");
    // operation forms
    let formCreateQuiz = document.getElementById("create-quiz-form");
    let formNewPost = document.getElementById("new-post-form");
    let editCourseDiv = document.getElementById("edit-course-info-div");
    // Create New Post
    function newPost(){
        formNewPost.classList.add("d-block");
        if (formCreateQuiz.classList.contains("d-block"))
            formCreateQuiz.classList.remove("d-block");

        if (editCourseDiv.classList.contains("d-block"))
            editCourseDiv.classList.remove("d-block");
        formNewPost.scrollIntoView();
    }

    // Hide post creator form
    function hidePostForm(){
        formNewPost.classList.remove("d-block");
        document.getElementById("course-header").scrollIntoView();
    }

    // Create New Quiz
    function createQuiz(){
        formCreateQuiz.classList.add("d-block");
        if (formNewPost.classList.contains("d-block"))
            formNewPost.classList.remove("d-block");

        if (editCourseDiv.classList.contains("d-block"))
            editCourseDiv.classList.remove("d-block");
        formCreateQuiz.scrollIntoView();

    }

    // Hid Quiz form
    function hideQuizForm(){
        formCreateQuiz.classList.remove("d-block");
        document.getElementById("course-header").scrollIntoView();
    }

    // Edit Course Properties
    function editCourse() {
        editCourseDiv.classList.add("d-block");

        if (formNewPost.classList.contains("d-block"))
            formNewPost.classList.remove("d-block");

        if (formCreateQuiz.classList.contains("d-block"))
            formCreateQuiz.classList.remove("d-block");

        editCourseDiv.scrollIntoView();
    }

    // Hide Course Edit
    function hideEditCourse() {
        editCourseDiv.classList.remove("d-block");
        document.getElementById("course-header").scrollIntoView();
    }


    // Show and hide url input in post form
    let link = document.getElementById("link");
    let btnLink = document.getElementById("link-btn");

    function urlVisibility() {
        if (link.classList.contains("d-none")){
            link.classList.remove("d-none");
        }else {
            link.classList.add("d-none");
        }
    }


    //Students number of requests badge
    let numberOfStdsRqsts = document.getElementById("number-of-stds-rqsts");
    document.onload = new function () {
        if (numberOfStdsRqsts.innerText.length === 0){
            numberOfStdsRqsts.classList.add("d-none");
        }else{
            numberOfStdsRqsts.classList.remove("d-none");
        }
    }



    // create new question - quiz page


    function imgShower(imgFileId, imgId) {
        let upload_img = document.getElementById(imgId);
        let img_file = document.getElementById(imgFileId);
        upload_img.src = window.URL.createObjectURL(img_file.files[0])
        upload_img.classList.remove("d-none")
    }


    function deleteImgAnswer(imgFileId, imgId) {
        let upload_img = document.getElementById(imgId);
        let img_file = document.getElementById(imgFileId);
        console.log(img_file.value)
        img_file.value = null;
        upload_img.src = null;
        upload_img.classList.add("d-none")
    }




    function AddQuestionDivShow_hide(){
       let addQuestionDiv = document.getElementById("add-question-div");
       if (addQuestionDiv.classList.contains("d-none")){
           addQuestionDiv.classList.remove("d-none");
           addQuestionDiv.scrollIntoView();
       }else {
           hideAddQuestionDiv();
       }
    }

    function hideAddQuestionDiv() {
        let addQuestionDiv = document.getElementById("add-question-div");
        addQuestionDiv.classList.add("d-none");
    }


    function editQuizDivShow_hide() {
        let editQuizDiv = document.getElementById("edit-quiz");
        if (editQuizDiv.classList.contains("d-none")){
            editQuizDiv.classList.remove("d-none");
            editQuizDiv.scrollIntoView();
        }else {
            editQuizDiv.classList.add("d-none");
        }
    }
    
    function hideEditQuiz() {
        let editQuizDiv = document.getElementById("edit-quiz");
        editQuizDiv.classList.add("d-none");
    }


    //Styling













