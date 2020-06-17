<template>
	<div class="announcement-list">
		<div class="empty-announcement" v-if="!announcements.length">
			No Announcements for now.
		</div>
		<div v-else>
			<div v-for="(item, index) in announcements" :key="index"
				class="item" :class="checkIfUnread(item.read_at)"
				@click="openAnnouncement(item)">
				<div class="item-left">
					<h3 class="ellipsis">{{ item.data.topic }}</h3>
					<p class="ellipsis">{{ item.data.content }}</p>
				</div>
				<div class="item-right">
					<p>{{ dateFormat(item.created_at) }}</p>
				</div>
			</div>
			<div class="item show-all" @click="showAllAnnouncements">
				<div class="has-text-centered">
					<h3 class="has-text-centered">Show All</h3>
				</div>
			</div>
		</div>

		<Modal :title="announcement.topic"
	        @close="closeAnnouncementModal"
	        :isOpen="isShowAnnouncementModal">
	        <!-- Body -->
			<div class="columns">
				<div class="column">
					<p class="has-text-gray-primary"
						v-text="announcement.content"></p>
				</div>
			</div>

	        <span slot="footer">
	            <button class="button" @click="closeAnnouncementModal">Okay</button>
	        </span>
	    </Modal>
	</div>
</template>

<script>

import moment from 'moment';
import Modal from "@components/global/Modal";

/**
 * Announcement list on navbar
 */
export default {
	name: 'AnnouncementList',

	components: {
		Modal,
	},

	data() {
		return {
			isShowAnnouncementModal: false,
			announcement:{
				topic: '',
				content: '',
			},
		}
	},
	/**
	 * Computed
	 * @type {Object}
	 */
	computed: {

		announcements()
		{
			return this.$store.getters['userAnnouncement/items'];
		},
	},

	methods: {

		checkIfUnread(date)
		{
			let style = {};
			if (date === null || date == '') {
				style = {'has-primary-background': true};
			}
			return style;
		},

		/**
		 * Convert date
		 * @param  {[type]} date
		 * @return {[type]}
		 */
		dateFormat(date)
		{
			return moment(date).format('L')
		},

		/**
		 * Show all announcements
		 * @return {void}
		 */
		showAllAnnouncements()
		{
			window.AppEvent.emit('user.announcements.show-all');
		},

		/**
		 * Open announcement
		 * @param {integer} $id
		 * @return {void}
		 */
		openAnnouncement(announcement)
		{
			let {id} = announcement;
			this.$store.dispatch('userAnnouncement/updateMarkAsRead', id);

			// Show announcement details
			this.isShowAnnouncementModal = true;
			this.announcement = announcement.data;
		},

		closeAnnouncementModal()
		{
			this.isShowAnnouncementModal = false;
			this.$store.dispatch('userAnnouncement/fetchUnread');
		},
	},

	mounted()
	{
		this.$store.dispatch('userAnnouncement/fetchUnread');
	}
}
</script>

<style scoped lang="scss">
.announcement-list {
	position: relative;
	color: #fff;
	width: 300px;
	padding: 15px;

	.empty-announcement {
		text-align: center;
	}

	.show-all {
		justify-content: center;

	}

	.add-button {
		position: absolute;
		top: 10px;
		right: 15px;
		cursor: pointer;
		background: transparent;
		color: #32c5d2;
		border: 0;
		padding: 0px 5px;
		height: auto;
		font-size: 12px;
		&:focus {
			box-shadow: none;
		}
	}

	.item {
		width: 100%;
		background: #39424a;
		padding: 10px 15px;
		margin-bottom: 10px;
		display: flex;
		align-items: center;

		&:hover {
			cursor: pointer;
		}

		&:last-child {
			margin-bottom: 0;
		}

		.ellipsis {
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		> .item-left {
			flex-grow: 1;
			width: 100%;
			> h3 {
				font-size: 15px;
				font-weight: bold;
				margin-bottom: 3px;
				color: #f9f9f9;
				width: 100px;
			}
			> p {
				font-size: 12px;
				color: #f9f9f9;
				margin: 0;
				width: 130px;
			}
		}
		> .item-right {
			width: 100px;
			text-align: right;
			> p {
				font-size: 13px;
				color: #fff;
				margin: 0;
			}
		}
	}
}
</style>
