<script type="application/javascript">

    //Pour utiliser fetch, la fonction doit être "asynchrone"
    async function loadMorePosts(numberOfPostsAlready) {

        const element = document.getElementById('morePosts');
        if (element != null ) {element.remove();}

        var searchJS = "<?php echo $search; ?>";
        var typeSearch = "<?php echo $typeSearch; ?>";
        var query = "<?php echo $_SERVER['QUERY_STRING']; ?>";


        var AJAXresult = await fetch("./loadMore.php?firstPost=" + numberOfPostsAlready + "&" + query + "&typeSearch=" + typeSearch + "&search=" + searchJS);
        var writearea = document.getElementById("ShowPosts");
        writearea.innerHTML = writearea.innerHTML + await AJAXresult.text();

    }

    window.onload = loadMorePosts(0);

</script>

<h1>Résultat de la recherche : <?php $search ?> </h1>
<div id="ShowPosts">
    <!-- les posts seront écrits là par AJAX/fetch -->
</div>
