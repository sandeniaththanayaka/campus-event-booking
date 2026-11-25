<?php
$pageTitle = 'Events';
include 'includes/header.php';
?>

<div class="container py-4" ng-app="eventApp" ng-controller="EventController">
    <h2 class="fw-bold mb-3">Upcoming Events</h2>

    <!-- Search සහ Filter -->
    <div class="row g-2 mb-4">
        <div class="col-md-8">
            <input type="text" class="form-control" ng-model="searchText"
                   placeholder="Search by event name or venue...">
        </div>
        <div class="col-md-4">
            <select class="form-select" ng-model="selectedCategory">
                <option value="">All Categories</option>
                <option ng-repeat="c in categories" value="{{c}}">{{c}}</option>
            </select>
        </div>
    </div>

    <p ng-if="loading">Loading events...</p>
    <div class="alert alert-danger" ng-if="error">Could not load events. Please try again.</div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4" ng-repeat="ev in events | filter:matchEvent">
            <div class="event-card">
                <span class="badge bg-primary mb-2">{{ev.category}}</span>
                <h5 class="fw-bold">{{ev.title}}</h5>
                <p class="small text-muted mb-1"><i class="bi bi-calendar-event"></i> {{ev.event_date | date:'mediumDate'}} at {{ev.event_time.substring(0,5)}}</p>
                <p class="small text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ev.venue}}</p>
                <p class="small mb-2">
                    <i class="bi bi-cash"></i>
                    <span ng-if="ev.ticket_price > 0">LKR {{ev.ticket_price | number:2}} per seat</span>
                    <span ng-if="ev.ticket_price == 0">Free</span>
                </p>

                <p class="mb-3">
                    <span class="badge bg-danger" ng-if="ev.available_seats <= 0">Sold Out</span>
                    <span class="badge bg-success" ng-if="ev.available_seats > 0">{{ev.available_seats}} seats left</span>
                </p>

                <a href="event-details.php?id={{ev.event_id}}" class="btn btn-primary-custom btn-sm">View Details</a>
            </div>
        </div>
    </div>

    <p class="text-center text-muted mt-4"
       ng-if="!loading && (events | filter:matchEvent).length === 0">
        No events found.
    </p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.3/angular.min.js"></script>
<script src="assets/js/app.js"></script>
<?php include 'includes/footer.php'; ?>