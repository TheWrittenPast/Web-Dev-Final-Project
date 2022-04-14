<?php 
/*               
 *      Name: John Russel Tabelina
 *      Date: March 21, 2022
 *      Description: select
 */

$gameSet = "SELECT * FROM games";

$gameStatement = $db->prepare($gameSet);

$gameStatement->execute(); 

?>

<nav>
    <?php if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin' ) :?>
        <ul>
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
            <li><a href="admin.php" >Admin</a></li>
        </ul>
        <form action="index.php" method="post">
        <input type="text" name="keyword" placeholder="Search for keyword" />
            <select name="games">
                <option value="All">All</option>
                <?php while($gameRow = $gameStatement->fetch()) :?>
                    <option value="<?= $gameRow['Game']?>"><?= $gameRow['Game'] ?></option>
                <?php endwhile ?>
            </select>
            <input type="submit" name="navCommand" value="Search" />
        </form>
        <form action="action_page.php" method="post">
            <input type="submit" name="command" value="Log off" />
        </form>
    <?php elseif(isset($_SESSION['username']) && $_SESSION['role'] == 'user')  : ?>
        <ul>
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
        </ul>
        <form action="index.php" method="post">
        <input type="text" name="keyword" placeholder="Search for keyword" />
            <select name="games">
                <option value="All">All</option>
                <?php while($gameRow = $gameStatement->fetch()) :?>
                    <option value="<?= $gameRow['Game']?>"><?= $gameRow['Game'] ?></option>
                <?php endwhile ?>
            </select>
            <input type="submit" name="navCommand" value="Search" />
        </form>
        <form action="action_page.php" method="post">
            <input type="submit" name="command" value="Log off" />
        </form>
    <?php else: ?>
        <ul>
            <li><a href="index.php" class='active'>Home</a></li>
        </ul>
        <form action="index.php" method="post">
        <input type="text" name="keyword" placeholder="Search for keyword" />
            <select name="games">
                <option value="All">All</option>
                <?php while($gameRow = $gameStatement->fetch()) :?>
                    <option value="<?= $gameRow['Game']?>"><?= $gameRow['Game'] ?></option>
                <?php endwhile ?>
            </select>
            <input type="submit" name="navCommand" value="Search" />
        </form>
        <form action="login.php" method="get">
            <button>Login </button>
        </form>
        <form action="register.php" method="get">
            <button>Register</button>
        </form>
    <?php endif ?>
</nav>