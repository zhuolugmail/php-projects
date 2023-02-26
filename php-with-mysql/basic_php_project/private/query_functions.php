<?php

function db_find_all_subjects($opts = [])
{
    global $db;
    try {
        $sql = 'SELECT * FROM subjects ';
        if (isset($opts['visible']))
            $sql .= 'WHERE visible = ' . $opts['visible'] . ' ';
        $sql .= 'ORDER BY position ASC';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_find_all_pages($opts = [])
{
    global $db;
    try {
        $sql = 'SELECT * FROM pages ';
        if (isset($opts['visible']))
            $sql .= 'WHERE visible = ' . $opts['visible'] . ' ';
        $sql .= 'ORDER BY subject_id ASC, position ASC';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_find_all_admins()
{
    global $db;
    try {
        $sql = 'SELECT * FROM admins;';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_rows($table)
{
    global $db;
    $sql = 'select count(*) from ';
    $sql .= $table;
    $result = $db->query($sql);
    $nRows = $result->fetchColumn();
    $result = null;
    return $nRows;
}

function db_find_subject($id, $opts = [])
{
    global $db;
    try {
        $sql = 'SELECT * FROM subjects ';
        $sql .= 'WHERE id ="' . $id . '" ';
        if (isset($opts['visible']))
            $sql .= 'AND visible = ' . $opts['visible'] . ' ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    $results = null;
    return $result;
}

function db_find_page($id, $opts = [])
{
    global $db;
    try {
        $sql = 'SELECT * FROM pages ';
        $sql .= 'WHERE id ="' . $id . '" ';
        if (isset($opts['visible']))
            $sql .= 'AND visible = ' . $opts['visible'] . ' ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        return null;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    $results = null;
    return $result;
}

function db_find_admin($id)
{
    global $db;
    try {
        $sql = 'SELECT * FROM admins ';
        $sql .= 'WHERE id ="' . $id . '" ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        return null;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    $results = null;
    return $result;
}

function validate_subject($subject)
{
    $errors = [];
    if (is_blank($subject['menu_name'])) {
        $errors[] = 'Name cannot be blank.';
    }
    if (
        !has_length(
            $subject['menu_name'],
            ['min' => 2, 'max' => 255]
        )
    ) {
        $errors[] = 'Name must have between 2 and 255 characters.';
    }
    $position_int = (int) $subject['position'];
    if ($position_int <= 0 || $position_int > 999) {
        $errors[] = 'Position must be between 0 and 999';
    }
    $visible_str = (string) $subject['visible'];
    if (!has_inclusion_of($visible_str, ['0', '1'])) {
        $errors[] = 'Visible must be 0 or 1';
    }
    return $errors;
}

function db_insert_subject($menu_name, $position, $visible)
{
    $errors = validate_subject([
        'menu_name' => $menu_name,
        'position' => $position,
        'visible' => $visible
    ]);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    try {
        $sql = 'INSERT INTO subjects ';
        $sql .= '(menu_name, position, visible) ';
        $sql .= 'VALUES(:menu_name, :position, :visible)';
        $statement = $db->prepare($sql);
        $statement->execute([
            'menu_name' => $menu_name,
            'position' => $position,
            'visible' => $visible
        ]);
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function validate_page($page)
{
    $errors = [];
    if (is_blank($page['menu_name'])) {
        $errors[] = 'Name cannot be blank.';
    }
    if (
        !has_length(
            $page['menu_name'],
            ['min' => 2, 'max' => 255]
        )
    ) {
        $errors[] = 'Name must have between 2 and 255 characters.';
    }
    $position_int = (int) $page['position'];
    if ($position_int <= 0 || $position_int > 999) {
        $errors[] = 'Position must be between 0 and 999';
    }
    $visible_str = (string) $page['visible'];
    if (!has_inclusion_of($visible_str, ['0', '1'])) {
        $errors[] = 'Visible must be 0 or 1';
    }
    $subject = db_find_subject($page['subject_id']);
    if (!$subject) {
        $errors[] = 'invalid subject id';
    }
    return $errors;
}

function db_insert_page($menu_name, $subject_id, $position, $visible, $content)
{
    $errors = validate_page([
        'menu_name' => $menu_name,
        'subject_id' => $subject_id,
        'position' => $position,
        'visible' => $visible,
        'content' => $content
    ]);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    try {
        $sql = 'INSERT INTO pages ';
        $sql .= '(menu_name, subject_id, position, visible, content) ';
        $sql .= 'VALUES(:menu_name, :subject_id, :position, :visible, :content)';
        $statement = $db->prepare($sql);
        $statement->execute([
            'menu_name' => $menu_name,
            'subject_id' => $subject_id,
            'position' => $position,
            'visible' => $visible,
            'content' => $content
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_find_admin_by_username($username)
{
    global $db;
    try {
        $sql = 'SELECT * FROM admins ';
        $sql .= 'WHERE username="' . $username . '"';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    $results = null;
    return $result;
}

function validate_admin($admin, $opts = [])
{
    $errors = [];
    if (is_blank($admin['first_name'])) {
        $errors[] = 'First name cannot be blank.';
    }
    if (
        !has_length(
            $admin['first_name'],
            ['min' => 1, 'max' => 255]
        )
    ) {
        $errors[] = 'First name must have between 1 and 255 characters.';
    }
    if (is_blank($admin['last_name'])) {
        $errors[] = 'Last name cannot be blank.';
    } else {
        if (
            !has_length(
                $admin['last_name'],
                ['min' => 1, 'max' => 255]
            )
        ) {
            $errors[] = 'Last name must have between 1 and 255 characters.';
        }
    }
    if (is_blank($admin['email'])) {
        $errors[] = 'Email cannot be blank.';
    } else {
        if (!has_valid_email_format($admin['email'])) {
            $errors[] = 'Must enter a valid email.';
        }
    }
    if (is_blank($admin['username'])) {
        $errors[] = 'Username cannot be blank.';
    } else {
        if (
            !has_length(
                $admin['username'],
                ['min' => 3, 'max' => 255]
            )
        ) {
            $errors[] = 'Username must have between 3 and 255 characters.';
        }
    }
    if ($opts['require_password']) {
        if (is_blank($admin['password'])) {
            $errors[] = 'Password cannot be blank.';
        } else {
            if (
                !has_length(
                    $admin['password'],
                    ['min' => 6, 'max' => 255]
                )
            ) {
                $errors[] = 'Password must have between 6 and 255 characters.';
            } else {
                if ($admin['password'] != $admin['confirm_password']) {
                    $errors[] = 'Password and confirm password must match.';
                }
            }
        }
    }
    return $errors;
}

function db_insert_admin($admin)
{
    $errors = validate_admin($admin, opts: ['require_password' => true]);
    $result = db_find_admin_by_username($admin['username']);
    if ($result)
        $errors[] = 'Username must be unique.';
    if (!empty($errors)) {
        return $errors;
    }
    unset($admin['confirm_password']);
    $admin['hashed_password'] =
        password_hash($admin['password'], PASSWORD_BCRYPT);
    var_dump($admin);
    unset($admin['password']);
    global $db;
    try {
        $sql = 'INSERT INTO admins ';
        $sql .= '(first_name, last_name, email, username, hashed_password) ';
        $sql .= 'VALUES(:first_name, :last_name, :email, :username, :hashed_password)';
        $statement = $db->prepare($sql);
        $statement->execute($admin);
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_update_subject($id, $menu_name, $position, $visible)
{
    $errors = validate_subject([
        'menu_name' => $menu_name,
        'position' => $position,
        'visible' => $visible
    ]);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    try {
        $sql = 'UPDATE subjects SET ';
        $sql .= 'menu_name=:menu_name, position=:position, visible=:visible ';
        $sql .= 'where id=:id LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $id,
            'menu_name' => $menu_name,
            'position' => $position,
            'visible' => $visible
        ]);
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_update_page($id, $menu_name, $subject_id, $position, $visible, $content)
{
    $errors = validate_page([
        'menu_name' => $menu_name,
        'subject_id' => $subject_id,
        'position' => $position,
        'visible' => $visible,
        'content' => $content
    ]);
    if (!empty($errors)) {
        return $errors;
    }

    global $db;
    try {
        $sql = 'UPDATE pages SET ';
        $sql .= 'menu_name=:menu_name, subject_id=:subject_id, ';
        $sql .= 'position=:position, visible=:visible, ';
        $sql .= 'content=:content ';
        $sql .= 'where id=:id LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute([
            'id' => $id,
            'menu_name' => $menu_name,
            'subject_id' => $subject_id,
            'position' => $position,
            'visible' => $visible,
            'content' => $content
        ]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_update_admin($admin)
{
    if (is_blank($admin['password'])) {
        $require_password = false;
    } else {
        $require_password = true;
    }
    $errors = validate_admin($admin, opts: ['require_password' => $require_password]);
    if (!empty($errors)) {
        return $errors;
    }
    unset($admin['confirm_password']);
    if ($require_password) {
        $admin['hashed_password'] =
            password_hash($admin['password'], PASSWORD_BCRYPT);
    }
    unset($admin['password']);
    global $db;
    try {
        $sql = 'UPDATE admins SET ';
        $sql .= 'first_name=:first_name, last_name=:last_name, ';
        $sql .= 'email=:email, username=:username';
        if ($require_password)
            $sql .= ', hashed_password=:hashed_password';
        $sql .= ' where id=:id LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute($admin);
    } catch (PDOException $e) {
        echo $e->getMessage();
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_delete_subject($id)
{
    global $db;
    try {
        $sql = 'DELETE FROM subjects ';
        $sql .= 'WHERE id = :id ';
        $sql .= 'LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute(['id' => $id]);
    } catch (PDOException $e) {
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_delete_page($id)
{
    global $db;
    try {
        $sql = 'DELETE FROM pages ';
        $sql .= 'WHERE id = :id ';
        $sql .= 'LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute(['id' => $id]);
    } catch (PDOException $e) {
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_delete_admin($id)
{
    global $db;
    try {
        $sql = 'DELETE FROM admins ';
        $sql .= 'WHERE id = :id ';
        $sql .= 'LIMIT 1';
        $statement = $db->prepare($sql);
        $statement->execute(['id' => $id]);
    } catch (PDOException $e) {
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_find_pages_by_subject_id($subject_id, $opts = [])
{
    global $db;
    try {
        $sql = 'SELECT * FROM pages ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '" ';
        if (isset($opts['visible']))
            $sql .= 'AND visible = ' . $opts['visible'] . ' ';
        $sql .= 'ORDER BY position ASC';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_count_pages_by_subject_id($subject_id)
{
    global $db;
    try {
        $sql = 'SELECT COUNT(*) FROM pages ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '"';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    return $result['COUNT(*)'];
}

function db_subjectordering_all()
{
    global $db;
    try {
        $sql = 'SELECT * FROM subject_ordering ';
        $sql .= 'ORDER BY ordering';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_subjectordering_by_subject_id($subject_id)
{
    global $db;
    try {
        $sql = 'SELECT * FROM subject_ordering ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '" ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    return $result;
}

function db_subjectordering_by_ordering($ordering)
{
    global $db;
    try {
        $sql = 'SELECT * FROM subject_ordering ';
        $sql .= 'WHERE ordering ="' . $ordering . '" ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    return $result;
}

function db_subjectordering_max_ordering()
{
    global $db;
    try {

        $sql = 'SELECT MAX(ordering) from subject_ordering';
        $results = $db->query($sql);
        $result = $results->fetch();
        $ordering = $result['MAX(ordering)'];
        if (!$ordering)
            $ordering = 0;
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return $ordering;
}

function db_subjectordering_insert($subject_id, $ordering)
{
    global $db;
    try {
        if ($ordering == 0) {
            $sql = 'SELECT MAX(ordering) from subject_ordering';
            $results = $db->query($sql);
            $result = $results->fetch();
            $ordering = $result['MAX(ordering)'];
            if (!$ordering)
                $ordering = 1;
            else
                $ordering = $ordering + 1;
        }

        $sql = 'UPDATE subject_ordering SET ';
        $sql .= 'ordering = ordering+1 ';
        $sql .= 'WHERE ordering >= :ordering';

        $statement = $db->prepare($sql);

        $statement->execute([
            'ordering' => $ordering
        ]);
        $statement = null;

        $sql = 'INSERT INTO subject_ordering ';
        $sql .= '(ordering, subject_id) ';
        $sql .= 'VALUES(:ordering, :subject_id)';
        $statement = $db->prepare($sql);
        $statement->execute([
            'ordering' => $ordering,
            'subject_id' => $subject_id
        ]);
        $statement = null;

        $sql = 'UPDATE subjects SET ';
        $sql .= 'position = :ordering ';
        $sql .= 'WHERE id = :subject_id';

        $statement = $db->prepare($sql);

        $statement->execute([
            'ordering' => $ordering,
            'subject_id' => $subject_id
        ]);

    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_subjectordering_delete($subject_id)
{
    $result = db_subjectordering_by_subject_id($subject_id);

    global $db;
    try {
        $sql = 'DELETE FROM subject_ordering ';
        $sql .= 'WHERE subject_id=:subject_id';
        $statement = $db->prepare($sql);
        $statement->execute([
            'subject_id' => $subject_id
        ]);
        $statement = null;

        $sql = 'UPDATE subject_ordering SET ';
        $sql .= 'ordering = ordering-1 ';
        $sql .= 'WHERE ordering > :ordering';
        $statement = $db->prepare($sql);
        $statement->execute([
            'ordering' => $result['ordering']
        ]);
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_subjectordering_update($subject_id, $ordering)
{
    $result = db_subjectordering_delete($subject_id);
    if (!$result)
        return false;
    $result = db_subjectordering_insert($subject_id, $ordering);
    return $result;
}



/* ============== */


function db_pageordering_all($subject_id)
{
    global $db;
    try {
        $sql = 'SELECT * FROM subjectpage_ordering ';
        $sql .= 'ORDER BY ordering ';
        $sql .= 'WHERE subject_id = ' . $subject_id;
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    return $results;
}

function db_pageordering_by_page_id($subject_id, $page_id)
{
    global $db;
    try {
        $sql = 'SELECT * FROM subjectpage_ordering ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '" ';
        $sql .= 'AND page_id = "' . $page_id . '" ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    return $result;
}

function db_pageordering_by_ordering($subject_id, $ordering)
{
    global $db;
    try {
        $sql = 'SELECT * FROM subjectpage_ordering ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '" ';
        $sql .= 'AND ordering ="' . $ordering . '" ';
        $sql .= 'LIMIT 1';
        $results = $db->query($sql);
    } catch (PDOException $e) {
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $results->fetch();
    return $result;
}

function db_pageordering_max_ordering($subject_id)
{
    global $db;
    try {

        $sql = 'SELECT MAX(ordering) from subjectpage_ordering ';
        $sql .= 'WHERE subject_id ="' . $subject_id . '"';
        $results = $db->query($sql);
        $result = $results->fetch();
        $ordering = $result['MAX(ordering)'];
        if (!$ordering)
            $ordering = 0;
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return $ordering;
}

function db_pageordering_insert($subject_id, $page_id, $ordering)
{
    global $db;
    try {
        if ($ordering == 0) {
            $sql = 'SELECT MAX(ordering) from subjectpage_ordering ';
            $sql .= 'WHERE subject_id ="' . $subject_id . '"';
            $results = $db->query($sql);
            $result = $results->fetch();
            $ordering = $result['MAX(ordering)'];
            if (!$ordering)
                $ordering = 1;
            else
                $ordering = $ordering + 1;
        }

        $sql = 'UPDATE subjectpage_ordering SET ';
        $sql .= 'ordering = ordering+1 ';
        $sql .= 'WHERE subject_id = :subject_id ';
        $sql .= 'AND ordering >= :ordering';
        $statement = $db->prepare($sql);
        $statement->execute([
            'subject_id' => $subject_id,
            'ordering' => $ordering
        ]);
        $statement = null;

        $sql = 'INSERT INTO subjectpage_ordering ';
        $sql .= '(ordering, page_id, subject_id) ';
        $sql .= 'VALUES(:ordering, :page_id, :subject_id)';
        $statement = $db->prepare($sql);
        $statement->execute([
            'ordering' => $ordering,
            'subject_id' => $subject_id,
            'page_id' => $page_id
        ]);
        $statement = null;

        $sql = 'UPDATE pages SET ';
        $sql .= 'position = :ordering ';
        $sql .= 'WHERE id = :page_id AND subject_id = :subject_id';

        $statement = $db->prepare($sql);

        $statement->execute([
            'ordering' => $ordering,
            'subject_id' => $subject_id,
            'page_id' => $page_id
        ]);

    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_pageordering_delete($subject_id, $page_id)
{
    $result = db_pageordering_by_page_id($subject_id, $page_id);

    global $db;
    try {
        $sql = 'DELETE FROM subjectpage_ordering ';
        $sql .= 'WHERE subject_id=:subject_id AND page_id=:page_id';
        $statement = $db->prepare($sql);
        $statement->execute([
            'subject_id' => $subject_id,
            'page_id' => $page_id
        ]);
        $statement = null;

        $sql = 'UPDATE subjectpage_ordering SET ';
        $sql .= 'ordering = ordering-1 ';
        $sql .= 'WHERE ordering > :ordering ';
        $sql .= 'AND subject_id=:subject_id';

        $statement = $db->prepare($sql);
        $statement->execute([
            'ordering' => $result['ordering'],
            'subject_id' => $subject_id
        ]);
    } catch (PDOException $e) {
        $statement = null;
        return false;
        exit($e->getMessage());
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $statement = null;
    return true;
}

function db_pageordering_update($subject_id, $page_id, $ordering)
{
    $result = db_pageordering_delete($subject_id, $page_id);
    if (!$result)
        return false;
    $result = db_pageordering_insert($subject_id, $page_id, $ordering);
    return $result;
}

?>