<style>
.v-calendar-weekly__day > .v-calendar-weekly__day-label > button {
	height: 25px;
	width: 25px;
}
.v-calendar-daily_head-day > .v-calendar-daily_head-day-label > button {
	height: 30px;
	width: 30px;
}
.v-calendar .v-event-summary {
	font-size: 10px;
}
.v-calendar .v-event-more {
	font-size: 10px !important;
}
</style>

<template>
	<v-row class="fill-height" no-gutters>
		<v-col>
			<v-sheet>
				<v-toolbar
					flat
					dense
					:width=width
				>
					<v-btn
						outlined
						x-small
						class="mr-4"
						color="grey darken-2"
						@click="setToday"
					>
						今日
					</v-btn>
					<v-btn
						fab
						text
						x-small
						color="grey darken-2"
						@click="prev"
					>
						<v-icon x-small>
							mdi-chevron-left
						</v-icon>
					</v-btn>
					<v-btn
						fab
						text
						x-small
						color="grey darken-2"
						@click="next"
					>
						<v-icon x-small>
							mdi-chevron-right
						</v-icon>
					</v-btn>
					<v-toolbar-title v-if="$refs.calendar" class="text-body-2">
						{{ $refs.calendar.title }}
					</v-toolbar-title>
					<v-spacer></v-spacer>
					<v-menu
						bottom
						right
					>
						<template v-slot:activator="{ on, attrs }">
							<v-btn
								outlined
								x-small
								color="grey darken-2"
								v-bind="attrs"
								v-on="on"
							>
								<span>{{ typeToLabel[type] }}</span>
								<v-icon small right>
									mdi-menu-down
								</v-icon>
							</v-btn>
						</template>
						<v-list dense>
							<v-list-item @click="type = 'month'">
								<v-list-item-title>月</v-list-item-title>
							</v-list-item>
							<v-list-item @click="type = 'week'">
								<v-list-item-title>週</v-list-item-title>
							</v-list-item>
							<v-list-item @click="type = 'day'">
								<v-list-item-title>日</v-list-item-title>
							</v-list-item>
						</v-list>
					</v-menu>
				</v-toolbar>
			</v-sheet>
			<v-sheet :height=height :width=width>
				<v-calendar
					ref="calendar"
					v-model="focus"
					color="indigo lighten-3"
					:events="events"
					:event-color="getEventColor"
					:type="type"
					@click:event="showEvent"
					@click:more="viewDay"
					@click:date="viewDay"
					@change="updateRange"
					x-small
				></v-calendar>
				<v-menu
					v-model="selectedOpen"
					:close-on-content-click="false"
					:activator="selectedElement"
					offset-x
				>
					<v-card
						color="grey lighten-4"
						width="250px"
						flat
					>
						<v-toolbar
							:color="selectedEvent.color"
							dark
							dense
						>
							<v-btn x-small icon>
								<v-icon>mdi-pencil</v-icon>
							</v-btn>
							<v-toolbar-title>{{ selectedEvent.name }}</v-toolbar-title>
							<v-spacer></v-spacer>
							<v-btn x-small icon>
								<v-icon>mdi-heart</v-icon>
							</v-btn>
							<v-btn x-small icon>
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</v-toolbar>
						<v-card-text>
							<span> {{ selectedEvent.details }}</span>
						</v-card-text>
						<v-card-actions>
							<v-btn
								text
								color="secondary"
								small
								@click="selectedOpen = false"
							>
								キャンセル
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-menu>
			</v-sheet>
		</v-col>
	</v-row>
</template>

<script>
  export default {
		name: 'calendar',
		props: {
			holidays: { type: Array, default: [] },
			schedules: { type: Array, default: [] },
			width: { type: Number, default: null },
			height: { type: Number, default: null }
		},
    data() {
			return {
				focus: '',
				type: 'month',
				typeToLabel: {
					month: '月',
					week: '週',
					day: '日',
				},
				selectedEvent: {},
				selectedElement: null,
				selectedOpen: false,
				// eventsは[{}, {}]で格納すること。
				events: [],
			}
    },
    mounted () {
      this.$refs.calendar.checkChange()
    },
    methods: {
      viewDay ({ date }) {
        this.focus = date
        this.type = 'day'
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = ''
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          requestAnimationFrame(() => requestAnimationFrame(() => open()))
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange() {
        const events = []
		Object.keys(this.holidays).map(key => events.push({name: this.holidays[key], start: key, end: key, color: "red" }));
		this.schedules.forEach(e => events.push(e));
        this.events = events
      },
    },
  }
</script>