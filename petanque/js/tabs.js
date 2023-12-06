function openTab(event, id) {
    var i, tabcontent, tabtrigger;
    
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].className = tabcontent[i].className.replace(" active-tab", "");
    }
    document.getElementById(id).className += " active-tab";
    
    tabtrigger = document.getElementsByClassName("tab-trigger");
    for (i = 0; i < tabtrigger.length; i++) {
        tabtrigger[i].className = tabtrigger[i].className.replace(" active-tab", "");
    }
    event.currentTarget.className += " active-tab";
    window.location.hash = event.currentTarget.dataset.trigger;
}

window.addEventListener("load", () => {
    var id = window.location.hash.slice(1);

    if (id.length !== 0)
    {
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].className = tabcontent[i].className.replace(" active-tab", "");
        }
        document.getElementById(id).className += " active-tab";
        
        tabtrigger = document.getElementsByClassName("tab-trigger");
        for (i = 0; i < tabtrigger.length; i++) {
            tabtrigger[i].className = tabtrigger[i].className.replace(" active-tab", "");
        }
        document.querySelector('[data-trigger=' + id + ']').className += " active-tab";
    }
});