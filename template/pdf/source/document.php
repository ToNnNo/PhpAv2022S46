<style>
    .page { color: #333 }
    h1 { color: red; margin: 5px 0 }
    h2 { color: dodgerblue; margin: 5px 0 }
    table { width: 100% }
</style>
<page class="page">
    <h1>Formation PHP Avance - Dawan FOAD</h1>
    <p>
        <b>Novembre 2022</b>
    </p>

    <table>
        <tr>
            <th>Client</th>
            <td><?php echo $client; ?></td>
        </tr>
        <tr>
            <th>Formateur</th>
            <td>Menut Stéphane</td>
        </tr>
    </table>

    <h2>Architecture MVC</h2>
    <img src="<?php echo dirname(__DIR__, 3) . "/public/images/mvc-php-av.png" ?>" alt="" width="750">

    <h2>Design Pattern</h2>
    <ul>
        <li>Singleton</li>
        <li>Iterator</li>
        <li>Factory</li>
    </ul>
</page>
