import moment from 'moment'

function relativeTime(date) {
  return moment(date, 'YYYY-MM-DD hh:mm:ss').fromNow()
}

function stringDateFormat(date) {
  return moment(date).format('L')
}

export { relativeTime, stringDateFormat }
