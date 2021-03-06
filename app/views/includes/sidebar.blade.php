<div class="page-sidebar sidebar-fixed menu-compact" id="sidebar">
    <div class="sidebar-header-wrapper">
        <input type="text" class="searchinput">
        <i class="searchicon fa fa-search"></i>
        <div class="searchhelper">Search Reports, Charts, and Employees</div>
    </div>
    <ul class="nav sidebar-menu">
        <li class="{{$fieldActive=='Dashboard' ? 'active' : ''}}">
            <a href="dashboard">
                <i class="menu-icon glyphicon glyphicon-home"></i>
                <span class="menu-text"> Dashboard</span>
            </a>
        </li>
        <li class="{{$fieldActive=='Inventory' ? 'active' : ''}}">
            <a href="dashboard">
                <i class="menu-icon fa fa-bar-chart-o"></i>
                <span class="menu-text"> Inventory </span>
            </a>
        </li>
        <li class="{{$fieldActive=='Income' ? 'open' : ''}}">
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-money"></i>
                <span class="menu-text"> Point - Of - Sales </span>
                <i class="menu-expand"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="#">
                        <span class="menu-text">Sales</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-text">Expenses</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="{{$fieldActive=='Employees' ? 'open' : ''}}">
            <a href="#" class="menu-dropdown">
                <i class="menu-icon fa fa-users"></i>
                <span class="menu-text"> Employees </span>
                <i class="menu-expand"></i>
            </a>

            <ul class="submenu">
                <li class="{{$subfield=='list' ? 'active' : ''}}">
                    <a href="employee">
                        <span class="menu-text">Employee List</span>
                    </a>
                </li>
                <li>
                    <a href="treeview.html">
                        <span class="menu-text">Attendance</span>
                    </a>
                </li>
                <li class="{{$subfield=='salary' ? 'active' : ''}}">
                    <a href="salary">
                        <span class="menu-text">Salary Rate</span>
                    </a>
                </li>
                <li class="{{$subfield=='cashadvance' ? 'active' : ''}}">
                    <a href="cashadvance">
                        <span class="menu-text">Cash Advances</span>
                    </a>
                </li>
                <li>
                    <a href="treeview.html">
                        <span class="menu-text">Users</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--Payroll-->
        <li class="{{$fieldActive=='Payroll' ? 'active' : ''}}">
            <a href="payroll">
                <i class="menu-icon fa fa-picture-o"></i>
                <span class="menu-text">Payroll</span>
            </a>
        </li>
        <!--Profile-->
        <li>
            <a href="profile.html">
                <i class="menu-icon fa fa-picture-o"></i>
                <span class="menu-text">Profile</span>
            </a>
        </li>

    </ul>
    <!-- /Sidebar Menu -->
</div>
