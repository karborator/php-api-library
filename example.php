<?php
require_once("kyIncludes.php");

/**
 * Initialization.
 */
//client initialization
kyBase::init("http://mykayako.example.com/api/index.php", "<API key>", "<Secret key>");

/**
 * Optional. Setting defaults for new tickets.
 * Object identifiers may be different in your installation.
 * To find out proper identifier fetch all objects with:
 * kyTicketStatus::getAll()
 * kyTicketPriority::getAll()
 * kyTicketType::getAll()
 * and examine them.
 */

$default_status_id = 1;
$default_priority_id = 1;
$default_type_id = 1;
kyTicket::setDefaults($default_status_id, $default_priority_id, $default_type_id);

/**
 * Creating ticket.
 */

//load department, user and staff
$department = kyDepartment::get(1);
$user = kyUser::get(1);
$staff = kyStaff::get(1);

//create ticket
$new_ticket = $user->newTicket($department,
'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Aliquam placerat cursus augue sed adipiscing. Proin viverra egestas nulla et sollicitudin.',
	'Lorem ipsum 1')->setOwnerStaff($staff)->create();

$ticket_id = $new_ticket->getId();

/**
 * Changing ticket.
 */

//load ticket
$ticket = kyTicket::get($ticket_id);

//change status
$ticket->setStatusId(5)->update();

/**
 * Adding ticket post (as staff).
 */

//load ticket
$ticket = kyTicket::get($ticket_id);

//add new post
$new_ticket_post = $ticket->newPost($ticket->getOwnerStaff(), 'What??')->create();

/**
 * Adding ticket post with attachment (as user).
 */

//load ticket
$ticket = kyTicket::get($ticket_id);

//add new post
$new_ticket_post = $ticket->newPost($ticket->getUser(), 'Sorry, I forgot the attachment...')->create();

//add attachment to the post
$new_ticket_attachment = $new_ticket_post->newAttachmentFromFile('/path/to/file.pdf')->create();

/**
 * Searching for tickets (using helper).
 */
$tickets = kySearchTicket::createNew()->addDepartmentId(3)->addOwnerStaffId(3)->addOwnerStaffId(4)->search();

/**
 * Searching for tickets (using getAll).
 */
$tickets = kyTicket::getAll(array(1), array(5), array(1), array(1));