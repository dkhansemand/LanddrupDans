$(document).ready(() => {
    $('.button-collapse').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'left', // Choose the horizontal origin
      draggable: true // Choose whether you can drag to open on touch screens
    }
  );
    $('select').material_select();  

    $('.btnUserDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var userId = button.data('userid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Users/Delete&id=' + userId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

    $('.btnInstructorDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var userId = button.data('userid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Instructors/Delete&id=' + userId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

    $('.btnStylesDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var styleId = button.data('styleid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Styles/Delete&id=' + styleId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

    $('.btnLevelDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var levelld = button.data('levelid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Levels/Delete&id=' + levelld);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

     $('.btnAgeDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var ageId = button.data('ageid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Agegroups/Delete&id=' + ageId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

    $('.btnTeamDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var teamId = button.data('teamid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=Teams/Delete&id=' + teamId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });

    $('.btnPostDelete').on('click', (event) => {
        //console.log(event.currentTarget);
        var button = $(event.currentTarget); 
        var postId = button.data('postid');
        $('#deleteModal #btnDel').attr('href', './index.php?p=home&view=News/Delete&id=' + postId);
        /*console.log('UserId ', userId);
        console.log('Link ', $('#deleteModal #btnDel').attr('href'));*/
    });
});