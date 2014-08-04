<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 main">
            <h1 class="page-header">Dashboard</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                         width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#0d8fdb" cx="100" cy="100" r="100"/>
                        <a xlink:href="<?=site_url('admin/users')?>" class="counter" text-anchor="middle">
                            <?$user_count=isset($counters['users'])?$counters['users']:0?>
                            <text x="100" y="115" fill="#FFF"><?=$user_count?></text>
                        </a>
                        <h4>Users</h4>
                        <span class="text-muted">all members</span>
                    </svg>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                         width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#39dbac" cx="100" cy="100" r="100"/>
                        <a xlink:href="<?=site_url('admin/events')?>" class="counter" text-anchor="middle">
                            <?$future_events=isset($counters['future_events'])?$counters['future_events']:0?>
                            <text x="100" y="115" fill="#000"><?=$future_events?></text>
                        </a>
                        <h4>Events</h4>
                        <span class="text-muted">future events</span>
                    </svg>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                         width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#0d8fdb" cx="100" cy="100" r="100"/>
                        <a xlink:href="<?=site_url('admin/events')?>" class="counter" text-anchor="middle">
                            <?$custom_events=isset($counters['custom_events'])?$counters['custom_events']:0?>
                            <text x="100" y="115" fill="#000"><?=$custom_events?></text>
                        </a>
                        <h4>Events</h4>
                        <span class="text-muted">custom events</span>
                    </svg>
                </div>
            </div>
            <h2 class="sub-header">Section title</h2>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1,001</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>dolor</td>
                        <td>sit</td>
                    </tr>
                    <tr>
                        <td>1,002</td>
                        <td>amet</td>
                        <td>consectetur</td>
                        <td>adipiscing</td>
                        <td>elit</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>Integer</td>
                        <td>nec</td>
                        <td>odio</td>
                        <td>Praesent</td>
                    </tr>
                    <tr>
                        <td>1,003</td>
                        <td>libero</td>
                        <td>Sed</td>
                        <td>cursus</td>
                        <td>ante</td>
                    </tr>
                    <tr>
                        <td>1,004</td>
                        <td>dapibus</td>
                        <td>diam</td>
                        <td>Sed</td>
                        <td>nisi</td>
                    </tr>
                    <tr>
                        <td>1,005</td>
                        <td>Nulla</td>
                        <td>quis</td>
                        <td>sem</td>
                        <td>at</td>
                    </tr>
                    <tr>
                        <td>1,006</td>
                        <td>nibh</td>
                        <td>elementum</td>
                        <td>imperdiet</td>
                        <td>Duis</td>
                    </tr>
                    <tr>
                        <td>1,007</td>
                        <td>sagittis</td>
                        <td>ipsum</td>
                        <td>Praesent</td>
                        <td>mauris</td>
                    </tr>
                    <tr>
                        <td>1,008</td>
                        <td>Fusce</td>
                        <td>nec</td>
                        <td>tellus</td>
                        <td>sed</td>
                    </tr>
                    <tr>
                        <td>1,009</td>
                        <td>augue</td>
                        <td>semper</td>
                        <td>porta</td>
                        <td>Mauris</td>
                    </tr>
                    <tr>
                        <td>1,010</td>
                        <td>massa</td>
                        <td>Vestibulum</td>
                        <td>lacinia</td>
                        <td>arcu</td>
                    </tr>
                    <tr>
                        <td>1,011</td>
                        <td>eget</td>
                        <td>nulla</td>
                        <td>Class</td>
                        <td>aptent</td>
                    </tr>
                    <tr>
                        <td>1,012</td>
                        <td>taciti</td>
                        <td>sociosqu</td>
                        <td>ad</td>
                        <td>litora</td>
                    </tr>
                    <tr>
                        <td>1,013</td>
                        <td>torquent</td>
                        <td>per</td>
                        <td>conubia</td>
                        <td>nostra</td>
                    </tr>
                    <tr>
                        <td>1,014</td>
                        <td>per</td>
                        <td>inceptos</td>
                        <td>himenaeos</td>
                        <td>Curabitur</td>
                    </tr>
                    <tr>
                        <td>1,015</td>
                        <td>sodales</td>
                        <td>ligula</td>
                        <td>in</td>
                        <td>libero</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>