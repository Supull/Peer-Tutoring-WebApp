<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <link rel="stylesheet" href="./css/subjects.css"> 
</head> 
<body>
  <section> 
    <span></span> <span></span> <!-- ...other span elements... --> 
    <div class="signin"> 
      <div class="content"> 
        <h2>Sign up</h2> 
        <div class="form">
          <form action="includes/signup/subject_store.inc.php" method="post">
            <div class="checkbox-group">
              <label><input type="checkbox" name="subjects[]" value="math"> Math</label>
              <label><input type="checkbox" name="subjects[]" value="chemistry"> Chemistry</label>
              <label><input type="checkbox" name="subjects[]" value="biology"> Biology</label>
              <label><input type="checkbox" name="subjects[]" value="geography"> Geography</label>
              <label><input type="checkbox" name="subjects[]" value="history"> History</label>
              <label><input type="checkbox" name="subjects[]" value="physics"> Physics</label>
              <label><input type="checkbox" name="subjects[]" value="english_language"> English Language</label>
              <label><input type="checkbox" name="subjects[]" value="english_literature"> English Literature</label>
              <label><input type="checkbox" name="subjects[]" value="economics"> Economics</label>
              <label><input type="checkbox" name="subjects[]" value="computer_science"> Computer Science</label>
            </div>
            <div class="inputBox"> 
              <button type="submit">Sign-up</button>
            </div> 
          </form>

        </div> 
      </div> 
    </div> 
  </section> 
</body>
</html>
